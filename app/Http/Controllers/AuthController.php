<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\BlacklistedTokenRepository;
use App\Repositories\VerificationCodeRepository;
use App\DTOs\RegisterRequestDTO;
use App\DTOs\RegisterResponseDTO;
use App\DTOs\LoginRequestDTO;
use App\DTOs\LoginResponseDTO;
use App\DTOs\ForgotPasswordRequestDTO;
use App\DTOs\ResetPasswordRequestDTO;

/**
 * AuthController
 * Handles registration, login (with lockout), logout, and password reset.
 */
class AuthController extends Controller
{
    public function __construct(
        protected UserRepository             $userRepository,
        protected BlacklistedTokenRepository $blacklistedTokenRepository,
        protected VerificationCodeRepository $verificationCodeRepository,
    ) {}

    // =========================================================================
    // POST /api/auth/register
    // =========================================================================

    /**
     * Register a new user account.
     *
     * @return JsonResponse 201 on success | 409 if email already exists | 422 on validation failure
     */
    public function register(Request $request): JsonResponse
    {
        // 1. Validate incoming data
        $request->validate([
            'name'     => 'required|string|max:16',
            'email'    => 'required|string|email|max:100',
            'role_id'  => 'required|exists:roles,id',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
        ]);

        // 2. Map to request DTO
        $requestDTO = new RegisterRequestDTO(
            $request->name,
            $request->email,
            $request->password,
            $request->role_id
        );

        // 3. Prevent duplicate emails — 409 Conflict
        if ($this->userRepository->existsByEmail($requestDTO->email)) {
            return response()->json(['message' => 'Email already registered'], 409);
        }

        // 4. Build and persist the new user
        $user           = new User();
        $user->name     = $requestDTO->name;
        $user->email    = $requestDTO->email;
        $user->password = Hash::make($requestDTO->password);
        $user->role_id  = $requestDTO->role_id;

        $savedUser = $this->userRepository->save($user);

        // 5. Return 201 Created with response DTO
        $responseDTO = new RegisterResponseDTO($savedUser);

        return response()->json([
            'message' => 'User successfully registered',
            'user'    => $responseDTO,
        ], 201);
    }

    // =========================================================================
    // POST /api/auth/login
    // =========================================================================

    /**
     * Authenticate a user and return a signed JWT.
     * Tracks failed attempts and enforces a temporary lockout after
     * VerificationCodeRepository::MAX_FAILED_ATTEMPTS consecutive failures.
     *
     * @return JsonResponse 200 with token | 401 bad credentials | 403 locked out | 422 validation failure
     */
    public function login(Request $request): JsonResponse
    {
        // 1. Validate incoming data
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        // 2. Map to request DTO
        $requestDTO = new LoginRequestDTO(
            $request->email,
            $request->password,
        );

        // 3. Check whether the user exists — needed to look up lockout state
        $user = $this->userRepository->findByEmail($requestDTO->email);

        if ($user) {
            // 4. Reject immediately if the account is temporarily locked out
            if ($this->verificationCodeRepository->isLockedOut($user->id)) {
                $unlocksAt = $this->verificationCodeRepository->lockoutExpiresAt($user->id);

                return response()->json([
                    'message'    => 'Account temporarily locked due to too many failed attempts',
                    'unlocks_at' => $unlocksAt?->toDateTimeString(),
                ], 403);
            }
        }

        // 5. Attempt JWT authentication
        $credentials = [
            'email'    => $requestDTO->email,
            'password' => $requestDTO->password,
        ];

        try {
            $token = JWTAuth::attempt($credentials);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token, please try again'], 500);
        }

        // 6. Wrong credentials — increment failed attempts counter
        if (!$token) {
            if ($user) {
                $record    = $this->verificationCodeRepository->incrementFailedAttempts($user->id);
                $remaining = $this->verificationCodeRepository->remainingAttempts($user->id);

                // Account just got locked on this attempt
                if ($record->date_to_resend) {
                    return response()->json([
                        'message'    => 'Account temporarily locked due to too many failed attempts',
                        'unlocks_at' => $record->date_to_resend,
                    ], 403);
                }

                return response()->json([
                    'message'            => 'Invalid credentials',
                    'remaining_attempts' => $remaining,
                ], 401);
            }

            // Email not found — return same message to avoid user enumeration
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // 7. Successful login — reset any previous failed attempts
        $this->verificationCodeRepository->resetFailedAttempts($user->id);

        // 8. Return response DTO with token
        $responseDTO = new LoginResponseDTO($user, $token);

        return response()->json([
            'message' => 'Login successful',
            'user'    => $responseDTO,
        ], 200);
    }

    // =========================================================================
    // POST /api/auth/logout
    // =========================================================================

    /**
     * Invalidate the current JWT by storing it in the blacklist.
     *
     * @return JsonResponse 200 on success | 401 if no token provided
     */
    public function logout(Request $request): JsonResponse
    {
        // 1. Extract the raw token from the Authorization header
        try {
            $rawToken = JWTAuth::getToken();

            if (!$rawToken) {
                return response()->json(['message' => 'Token not provided'], 401);
            }

            // 2. Decode the token to read the 'exp' claim
            $payload = JWTAuth::getPayload($rawToken);

        } catch (JWTException $e) {
            return response()->json(['message' => 'Invalid or expired token'], 401);
        }

        // 3. Persist the token in the blacklist before invalidating
        $this->blacklistedTokenRepository->blacklist(
            userId:    auth()->id(),
            token:     (string) $rawToken,
            expiresAt: $payload->get('exp'),
        );

        // 4. Invalidate the token inside tymon/jwt-auth as well (best-effort)
        try {
            JWTAuth::invalidate($rawToken);
        } catch (JWTException) {
            // Token was already expired — blacklisting above is still sufficient
        }

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    // =========================================================================
    // POST /api/auth/forgot-password
    // =========================================================================

    /**
     * Generate a password reset code and send it to the user's email.
     * Always returns 200 even if the email is not found to prevent user enumeration.
     *
     * @return JsonResponse 200 always
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        // 1. Validate and map to DTO
        $requestDTO = ForgotPasswordRequestDTO::fromRequest($request);

        // 2. Look up the user — 404 if not found
        $user = $this->userRepository->findByEmail($requestDTO->email);

        if (!$user) {
            return response()->json([
                'message' => 'If that email is registered, a reset code has been sent'
            ], 200);
        }

        // 3. Generate reset code and dispatch email to the queue
        $record = $this->verificationCodeRepository->createResetCode($user->id);

        Mail::to($user->email)->queue(
            new ResetPasswordMail($record->code, VerificationCodeRepository::CODE_EXPIRY_MINUTES)
        );

        return response()->json([
            'message' => 'If that email is registered, a reset code has been sent'
        ], 200);
    }

    // =========================================================================
    // POST /api/auth/reset-password
    // =========================================================================

    /**
     * Verify the reset code and update the user's password.
     *
     * @return JsonResponse 200 on success | 400 invalid/expired code | 422 validation failure
     */
    public function resetPassword(Request $request): JsonResponse
    {
        // 1. Validate and map to DTO
        $requestDTO = ResetPasswordRequestDTO::fromRequest($request);

        // 3. Look up the user
        $user = $this->userRepository->findByEmail($requestDTO->email);

        if (!$user) {
            return response()->json(['message' => 'Invalid or expired reset code'], 400);
        }

        // 4. Verify the code is valid and not expired
        if (!$this->verificationCodeRepository->verifyResetCode($user->id, $requestDTO->code)) {
            return response()->json(['message' => 'Invalid or expired reset code'], 400);
        }

        // 5. Update the password
        $user->password = Hash::make($requestDTO->password);
        $this->userRepository->save($user);

        // 6. Delete the used reset code
        $this->verificationCodeRepository->deleteByUser($user->id);

        return response()->json(['message' => 'Password successfully reset'], 200);
    }
}
