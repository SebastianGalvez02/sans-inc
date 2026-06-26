<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Repositories\BlacklistedTokenRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Feature tests for RF-06 — profile editing (name and password).
 * Exercises the ProfileController endpoints end-to-end through the auth.jwt
 * middleware using a real JWT for the test user.
 */
class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    private const CURRENT_PASSWORD = 'OldPass1$';

    private User $user;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        // A valid role is required because users.role_id is a non-null FK.
        $role = Role::create([
            'role_name'   => 'User',
            'description' => 'Standard user',
        ]);

        $this->user = new User();
        $this->user->role_id  = $role->id;
        $this->user->name     = 'Tester';
        $this->user->email    = 'tester@example.com';
        $this->user->password = Hash::make(self::CURRENT_PASSWORD);
        $this->user->save();

        // Real JWT for the authenticated requests.
        $this->token = JWTAuth::fromUser($this->user);
    }

    /**
     * Helper: attach the Bearer token to a JSON request.
     */
    private function authHeaders(): array
    {
        return ['Authorization' => 'Bearer ' . $this->token];
    }

    // =========================================================================
    // PUT /api/user/profile — name
    // =========================================================================

    public function test_update_profile_requires_authentication(): void
    {
        $this->putJson('/api/user/profile', ['name' => 'New Name'])
            ->assertStatus(401);
    }

    public function test_update_profile_changes_name(): void
    {
        $this->withHeaders($this->authHeaders())
            ->putJson('/api/user/profile', ['name' => 'NewName'])
            ->assertStatus(200)
            ->assertJsonPath('user.name', 'NewName');

        $this->assertDatabaseHas('users', [
            'id'   => $this->user->id,
            'name' => 'NewName',
        ]);
    }

    public function test_update_profile_validates_name(): void
    {
        // Empty name
        $this->withHeaders($this->authHeaders())
            ->putJson('/api/user/profile', ['name' => ''])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

        // Name longer than the 16-char limit enforced at registration
        $this->withHeaders($this->authHeaders())
            ->putJson('/api/user/profile', ['name' => str_repeat('a', 17)])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    // =========================================================================
    // PUT /api/user/password — password
    // =========================================================================

    public function test_update_password_requires_authentication(): void
    {
        $this->putJson('/api/user/password', [
            'current_password'      => self::CURRENT_PASSWORD,
            'password'              => 'NewPass1$',
            'password_confirmation' => 'NewPass1$',
        ])->assertStatus(401);
    }

    public function test_update_password_success(): void
    {
        $this->withHeaders($this->authHeaders())
            ->putJson('/api/user/password', [
                'current_password'      => self::CURRENT_PASSWORD,
                'password'              => 'NewPass1$',
                'password_confirmation' => 'NewPass1$',
            ])
            ->assertStatus(200);

        $fresh = $this->user->fresh();

        // New password is stored hashed (never plain text) and verifies.
        $this->assertTrue(Hash::check('NewPass1$', $fresh->password));
        $this->assertNotEquals('NewPass1$', $fresh->password);
    }

    public function test_update_password_rejects_wrong_current_password(): void
    {
        $this->withHeaders($this->authHeaders())
            ->putJson('/api/user/password', [
                'current_password'      => 'WrongPass1$',
                'password'              => 'NewPass1$',
                'password_confirmation' => 'NewPass1$',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['current_password']);

        // Password must remain unchanged.
        $this->assertTrue(Hash::check(self::CURRENT_PASSWORD, $this->user->fresh()->password));
    }

    public function test_update_password_enforces_registration_rules(): void
    {
        // Too short / no number / no symbol
        $this->withHeaders($this->authHeaders())
            ->putJson('/api/user/password', [
                'current_password'      => self::CURRENT_PASSWORD,
                'password'              => 'abc',
                'password_confirmation' => 'abc',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['password']);

        // Letters + numbers but no symbol — must still fail (same as registration)
        $this->withHeaders($this->authHeaders())
            ->putJson('/api/user/password', [
                'current_password'      => self::CURRENT_PASSWORD,
                'password'              => 'Abcd1234',
                'password_confirmation' => 'Abcd1234',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_update_password_requires_confirmation(): void
    {
        $this->withHeaders($this->authHeaders())
            ->putJson('/api/user/password', [
                'current_password'      => self::CURRENT_PASSWORD,
                'password'              => 'NewPass1$',
                'password_confirmation' => 'Mismatch1$',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_update_password_blacklists_current_token(): void
    {
        // Change the password successfully.
        $this->withHeaders($this->authHeaders())
            ->putJson('/api/user/password', [
                'current_password'      => self::CURRENT_PASSWORD,
                'password'              => 'NewPass1$',
                'password_confirmation' => 'NewPass1$',
            ])
            ->assertStatus(200);

        // The token used must now be blacklisted...
        $this->assertTrue(
            app(BlacklistedTokenRepository::class)->isBlacklisted($this->token)
        );

        // ...and rejected on any subsequent protected request.
        $this->withHeaders($this->authHeaders())
            ->getJson('/api/user')
            ->assertStatus(401);
    }
}
