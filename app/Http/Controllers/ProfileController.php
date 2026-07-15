<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Repositories\UserRepository;
use App\Repositories\BlacklistedTokenRepository;
use App\DTOs\ProfileResponseDTO;
use App\Support\PasswordRules;

/**
 * ProfileController
 * Handles self-service profile editing for the authenticated user (RF-06):
 * changing the display name and changing the password.
 *
 * All actions operate exclusively on the JWT-authenticated user
 * ($request->user()), never on an arbitrary id — enforcing RN-02 / RNF-05
 * (a user may only modify their own account).
 */
class ProfileController extends Controller
{
    public function __construct(
        protected UserRepository             $userRepository,
        protected BlacklistedTokenRepository $blacklistedTokenRepository,
    ) {}

    // =========================================================================
    // PUT /api/user/profile
    // =========================================================================

    /**
     * Update the authenticated user's display name.
     * Uses the same name rules enforced at registration.
     *
     * @return JsonResponse 200 on success | 422 on validation failure | 401 if unauthenticated
     */
    public function updateProfile(Request $request): JsonResponse
    {
        // 1. Validate incoming data (same rule as AuthController::register)
        $request->validate([
            'name' => 'required|string|max:16',
        ]);

        // 2. Update the authenticated user only
        $user       = $request->user();
        $user->name = $request->name;

        $this->userRepository->save($user);

        // 3. Return 200 with a sanitised response DTO
        return response()->json([
            'message' => 'Profile successfully updated',
            'user'    => new ProfileResponseDTO($user),
        ], 200);
    }

    // =========================================================================
    // PUT /api/user/password
    // =========================================================================

    /**
     * Change the authenticated user's password.
     * Requires the current password and a confirmed new password that satisfies
     * the same complexity rules as registration (PasswordRules::strong()).
     * On success the current JWT is blacklisted, forcing the user to log in
     * again with the new credentials.
     *
     * @return JsonResponse 200 on success | 422 on validation failure | 401 if unauthenticated
     */
    public function updatePassword(Request $request): JsonResponse
    {
        // 1. Validate: current password must be correct (verified against the
        //    'api' / JWT guard) and the new password must be confirmed and strong.
        $request->validate([
            'current_password' => ['required', 'current_password:api'],
            'password'         => array_merge(['required', 'confirmed'], PasswordRules::strong()),
        ]);

        // 2. Hash and persist the new password (RNF-05: never store plain text)
        $user           = $request->user();
        $user->password = Hash::make($request->password);

        $this->userRepository->save($user);

        // 3. Invalidate the current JWT so it can no longer be used.
        //    Reuses the exact blacklist mechanism from AuthController::logout.
        try {
            $rawToken = JWTAuth::getToken();

            if ($rawToken) {
                $payload = JWTAuth::getPayload($rawToken);

                $this->blacklistedTokenRepository->blacklist(
                    userId:    $user->id,
                    token:     (string) $rawToken,
                    expiresAt: $payload->get('exp'),
                );

                // Best-effort invalidation inside tymon/jwt-auth as well
                try {
                    JWTAuth::invalidate($rawToken);
                } catch (JWTException) {
                    // Token already expired — blacklisting above is sufficient
                }
            }
        } catch (JWTException) {
            // Token unreadable — the password change above is still committed
        }

        return response()->json([
            'message' => 'Password successfully updated. Please log in again.',
        ], 200);
    }
}
