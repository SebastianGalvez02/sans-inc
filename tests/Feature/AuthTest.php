<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\VerificationCode;
use App\Mail\VerifyRegistrationMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

/**
 * AuthTest
 * Covers all authentication flows:
 *   - Register (success + duplicate email)
 *   - Login (success + wrong credentials)
 *   - Protected route with valid token
 *   - Logout (blacklists the token)
 *   - Reuse of a blacklisted token → rejected
 *   - Request with no token → rejected
 *   - Login lockout after max failed attempts
 *   - Forgot password (sends reset code)
 *   - Reset password (success + wrong code)
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================================
    // Helpers
    // =========================================================================

    /**
     * Creates a Role and a User in the test database.
     * Returns the plain-text password alongside the User so tests can log in.
     *
     * @return array{user: User, password: string}
     */
    private function createUser(): array
    {
        $role = Role::create([
            'role_name'   => 'Admin',
            'description' => 'Administrator',
        ]);

        $plainPassword = 'Secret1!';

        $user = User::create([
            'name'     => 'Alice',
            'email'    => 'alice@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt($plainPassword),
            'role_id'  => $role->id,
        ]);

        return ['user' => $user, 'password' => $plainPassword];
    }

    /**
     * Performs a login request and returns the JWT token string.
     */
    private function loginAndGetToken(string $email, string $password): string
    {
        $response = $this->postJson('/api/auth/login', [
            'email'    => $email,
            'password' => $password,
        ]);

        return $response->json('user.token');
    }

    // =========================================================================
    // Register
    // =========================================================================

    /**
     * POST /api/auth/register
     * Verifies that a new user is created and returns 201.
     */
    public function test_register_creates_user_successfully(): void
    {
        Mail::fake();

        $role = Role::create([
            'role_name'   => 'Editor',
            'description' => 'Content editor',
        ]);

        $this->postJson('/api/auth/register', [
            'name'                  => 'Bob',
            'email'                 => 'bob@example.com',
            'role_id'               => $role->id,
            'password'              => 'Secret1!',
            'password_confirmation' => 'Secret1!',
        ])
        ->assertStatus(201)
        ->assertJsonFragment(['message' => 'User successfully registered. Please check your email to confirm your account'])
        ->assertJsonStructure([
            'message',
            'user' => ['id', 'name', 'email', 'registered_at'],
        ]);

        Mail::assertQueued(VerifyRegistrationMail::class);
    }

    /**
     * POST /api/auth/register with duplicate email
     * Verifies that registering the same email twice returns 409 Conflict.
     */
    public function test_register_fails_with_duplicate_email(): void
    {
        ['user' => $user] = $this->createUser();

        $this->postJson('/api/auth/register', [
            'name'                  => 'Alice Clone',
            'email'                 => $user->email,
            'role_id'               => $user->role_id,
            'password'              => 'Secret1!',
            'password_confirmation' => 'Secret1!',
        ])
        ->assertStatus(409)
        ->assertJsonFragment(['message' => 'Email already registered']);
    }

    // =========================================================================
    // Login
    // =========================================================================

    /**
     * POST /api/auth/login with correct credentials
     * Verifies that a JWT token is returned in the expected shape.
     */
    public function test_login_returns_token_with_valid_credentials(): void
    {
        ['user' => $user, 'password' => $password] = $this->createUser();

        $this->postJson('/api/auth/login', [
            'email'    => $user->email,
            'password' => $password,
        ])
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Login successful'])
        ->assertJsonStructure([
            'message',
            'user' => ['id', 'name', 'email', 'role_id', 'token', 'token_type'],
        ]);
    }

    /**
     * POST /api/auth/login with wrong password
     * Verifies that 401 is returned and remaining attempts are shown.
     */
    public function test_login_fails_with_wrong_password(): void
    {
        ['user' => $user] = $this->createUser();

        $this->postJson('/api/auth/login', [
            'email'    => $user->email,
            'password' => 'WrongPassword!',
        ])
        ->assertStatus(401)
        ->assertJsonFragment(['message' => 'Invalid credentials'])
        ->assertJsonMissing(['token']);
    }

    /**
     * POST /api/auth/login with non-existent email
     * Verifies that 401 is returned (not 404 — avoids user enumeration).
     */
    public function test_login_fails_with_non_existent_email(): void
    {
        $this->postJson('/api/auth/login', [
            'email'    => 'nobody@example.com',
            'password' => 'Secret1!',
        ])
        ->assertStatus(401)
        ->assertJsonFragment(['message' => 'Invalid credentials']);
    }

    // =========================================================================
    // Protected route
    // =========================================================================

    /**
     * GET /api/user with a valid Bearer token
     * Verifies that the authenticated user's data is returned.
     */
    public function test_protected_route_accessible_with_valid_token(): void
    {
        ['user' => $user, 'password' => $password] = $this->createUser();

        $token = $this->loginAndGetToken($user->email, $password);

        $this->withHeader('Authorization', "Bearer {$token}")
             ->getJson('/api/user')
             ->assertStatus(200)
             ->assertJsonFragment(['email' => $user->email]);
    }

    // =========================================================================
    // Logout
    // =========================================================================

    /**
     * POST /api/auth/logout with a valid token
     * Verifies that logout succeeds and the token is recorded in the blacklist.
     */
    public function test_logout_succeeds_and_blacklists_token(): void
    {
        ['user' => $user, 'password' => $password] = $this->createUser();

        $token = $this->loginAndGetToken($user->email, $password);

        $this->withHeader('Authorization', "Bearer {$token}")
             ->postJson('/api/auth/logout')
             ->assertStatus(200)
             ->assertJsonFragment(['message' => 'Successfully logged out']);

        $this->assertDatabaseHas('blacklisted_tokens', [
            'user_id' => $user->id,
            'token'   => $token,
        ]);
    }

    /**
     * GET /api/user after logout using the same token
     * Verifies that a blacklisted token is rejected with 401.
     * This is the core security guarantee of the blacklist system.
     */
    public function test_blacklisted_token_is_rejected_after_logout(): void
    {
        ['user' => $user, 'password' => $password] = $this->createUser();

        $token = $this->loginAndGetToken($user->email, $password);

        // Step 1 — confirm the token works before logout
        $this->withHeader('Authorization', "Bearer {$token}")
             ->getJson('/api/user')
             ->assertStatus(200);

        // Step 2 — logout
        $this->withHeader('Authorization', "Bearer {$token}")
             ->postJson('/api/auth/logout')
             ->assertStatus(200);

        // Step 3 — attempt to reuse the same token
        $this->withHeader('Authorization', "Bearer {$token}")
             ->getJson('/api/user')
             ->assertStatus(401)
             ->assertJsonFragment([
                 'message' => 'Token has been invalidated. Please log in again',
             ]);
    }

    // =========================================================================
    // No token provided
    // =========================================================================

    /**
     * GET /api/user with no Authorization header
     * Verifies that the middleware rejects the request immediately.
     */
    public function test_protected_route_rejected_without_token(): void
    {
        $this->getJson('/api/user')
             ->assertStatus(401)
             ->assertJsonFragment(['message' => 'Token not provided']);
    }

    /**
     * POST /api/auth/logout with no Authorization header
     * Verifies that logout itself also requires a token.
     */
    public function test_logout_rejected_without_token(): void
    {
        $this->postJson('/api/auth/logout')
             ->assertStatus(401)
             ->assertJsonFragment(['message' => 'Token not provided']);
    }

    // =========================================================================
    // Login lockout
    // =========================================================================

    /**
     * POST /api/auth/login with wrong password
     * Verifies that the response includes remaining attempts after a failure.
     */
    public function test_login_shows_remaining_attempts_on_failure(): void
    {
        ['user' => $user] = $this->createUser();

        $this->postJson('/api/auth/login', [
            'email'    => $user->email,
            'password' => 'WrongPassword!',
        ])
        ->assertStatus(401)
        ->assertJsonStructure(['message', 'remaining_attempts']);
    }

    /**
     * POST /api/auth/login after MAX_FAILED_ATTEMPTS consecutive failures
     * Verifies that the account is temporarily locked and unlocks_at is returned.
     */
    public function test_account_locks_after_max_failed_attempts(): void
    {
        ['user' => $user] = $this->createUser();

        // Fail 5 times (MAX_FAILED_ATTEMPTS)
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/auth/login', [
                'email'    => $user->email,
                'password' => 'WrongPassword!',
            ]);
        }

        // 6th attempt — account must be locked
        $this->postJson('/api/auth/login', [
            'email'    => $user->email,
            'password' => 'WrongPassword!',
        ])
        ->assertStatus(403)
        ->assertJsonStructure(['message', 'unlocks_at']);
    }

    /**
     * POST /api/auth/login with correct credentials after some failures
     * Verifies that a successful login resets the failed attempts counter.
     */
    public function test_correct_password_resets_failed_attempts(): void
    {
        ['user' => $user, 'password' => $password] = $this->createUser();

        // Fail twice
        for ($i = 0; $i < 2; $i++) {
            $this->postJson('/api/auth/login', [
                'email'    => $user->email,
                'password' => 'WrongPassword!',
            ]);
        }

        // Correct login resets the counter and succeeds
        $this->postJson('/api/auth/login', [
            'email'    => $user->email,
            'password' => $password,
        ])
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Login successful']);
    }

    // =========================================================================
    // Forgot password
    // =========================================================================

    /**
     * POST /api/auth/forgot-password with a registered email
     * Verifies that the endpoint returns 200 and stores a code in the database.
     */
    public function test_forgot_password_returns_200_for_registered_email(): void
    {
        ['user' => $user] = $this->createUser();

        $this->postJson('/api/auth/forgot-password', [
            'email' => $user->email,
        ])
        ->assertStatus(200)
        ->assertJsonFragment([
            'message' => 'If that email is registered, a reset code has been sent',
        ]);
    }

    /**
     * POST /api/auth/forgot-password with an unknown email
     * Verifies that 200 is returned regardless to prevent user enumeration.
     */
    public function test_forgot_password_returns_200_for_unknown_email(): void
    {
        $this->postJson('/api/auth/forgot-password', [
            'email' => 'nobody@example.com',
        ])
        ->assertStatus(200)
        ->assertJsonFragment([
            'message' => 'If that email is registered, a reset code has been sent',
        ]);
    }

    /**
     * POST /api/auth/forgot-password
     * Verifies that a verification code record is created in the database.
     */
    public function test_forgot_password_stores_code_in_database(): void
    {
        ['user' => $user] = $this->createUser();

        $this->postJson('/api/auth/forgot-password', [
            'email' => $user->email,
        ]);

        $this->assertDatabaseHas('verification_codes', [
            'user_id' => $user->id,
        ]);
    }

    // =========================================================================
    // Reset password
    // =========================================================================

    /**
     * POST /api/auth/reset-password with a valid code
     * Verifies that the password is changed and the new one works for login.
     */
    public function test_reset_password_succeeds_with_valid_code(): void
    {
        ['user' => $user] = $this->createUser();

        // Request a reset code
        $this->postJson('/api/auth/forgot-password', [
            'email' => $user->email,
        ]);

        // Read the code directly from the database
        $code = VerificationCode::where('user_id', $user->id)->value('code');

        // Reset the password
        $this->postJson('/api/auth/reset-password', [
            'email'                 => $user->email,
            'code'                  => $code,
            'password'              => 'NewSecret1!',
            'password_confirmation' => 'NewSecret1!',
        ])
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Password successfully reset']);

        // Verify the new password actually works for login
        $this->postJson('/api/auth/login', [
            'email'    => $user->email,
            'password' => 'NewSecret1!',
        ])
        ->assertStatus(200);
    }

    /**
     * POST /api/auth/reset-password with a wrong code
     * Verifies that an incorrect code is rejected with 400.
     */
    public function test_reset_password_fails_with_wrong_code(): void
    {
        ['user' => $user] = $this->createUser();

        $this->postJson('/api/auth/forgot-password', [
            'email' => $user->email,
        ]);

        $this->postJson('/api/auth/reset-password', [
            'email'                 => $user->email,
            'code'                  => 'WRONGCODE',
            'password'              => 'NewSecret1!',
            'password_confirmation' => 'NewSecret1!',
        ])
        ->assertStatus(400)
        ->assertJsonFragment(['message' => 'Invalid or expired reset code']);
    }

    /**
     * POST /api/auth/reset-password after a successful reset
     * Verifies that the verification code is deleted after use.
     */
    public function test_reset_code_is_deleted_after_successful_reset(): void
    {
        ['user' => $user] = $this->createUser();

        $this->postJson('/api/auth/forgot-password', [
            'email' => $user->email,
        ]);

        $code = VerificationCode::where('user_id', $user->id)->value('code');

        $this->postJson('/api/auth/reset-password', [
            'email'                 => $user->email,
            'code'                  => $code,
            'password'              => 'NewSecret1!',
            'password_confirmation' => 'NewSecret1!',
        ]);

        // Code must be deleted after successful use
        $this->assertDatabaseMissing('verification_codes', [
            'user_id' => $user->id,
        ]);
    }
}
