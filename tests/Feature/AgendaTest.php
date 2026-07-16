<?php

namespace Tests\Feature;

use App\Models\Agenda;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Feature tests for RF-20/RF-21 — agenda module (client-only appointment
 * requests). Exercises the AgendaController endpoints end-to-end through
 * the api guard (JWT) + EnsureUserIsClient middleware, hitting /api/agenda
 * exactly as a real client does — not the (now removed) duplicate web.php
 * routes, and not via actingAs()/session, which bypassed the real guard.
 */
class AgendaTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================
    // Helpers
    // =========================================================

    /**
     * Creates a user with the given role and returns both the model
     * and a real JWT for it, mirroring the pattern used in
     * ProfileControllerTest so requests exercise the actual api guard.
     *
     * @return array{0: User, 1: string} [$user, $token]
     */
    private function createAuthenticatedUser(string $roleName): array
    {
        $role = Role::firstOrCreate(
            ['role_name' => $roleName],
            ['description' => $roleName]
        );

        $user = User::factory()->create(['role_id' => $role->id]);

        $token = JWTAuth::fromUser($user);

        return [$user, $token];
    }

    private function authHeaders(string $token): array
    {
        return ['Authorization' => 'Bearer ' . $token];
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'reason'         => 'Consulta sobre producto',
            'scheduled_date' => now()->addDays(3)->format('Y-m-d H:i:s'),
            'phone'          => '123456789',
        ], $overrides);
    }

    // =========================================================
    // Middleware — acceso por rol
    // =========================================================

    public function test_unauthenticated_user_cannot_access_agenda(): void
    {
        $this->getJson('/api/agenda')->assertStatus(401);
    }

    public function test_non_client_user_cannot_access_agenda(): void
    {
        [, $token] = $this->createAuthenticatedUser('user');

        $this->withHeaders($this->authHeaders($token))
            ->getJson('/api/agenda')
            ->assertStatus(403)
            ->assertJson(['message' => 'Acceso restringido a clientes.']);
    }

    public function test_client_user_can_access_agenda(): void
    {
        [, $token] = $this->createAuthenticatedUser('client');

        $this->withHeaders($this->authHeaders($token))
            ->getJson('/api/agenda')
            ->assertStatus(200);
    }

    // =========================================================
    // GET /api/agenda — listar agendas del usuario
    // =========================================================

    public function test_client_sees_only_their_own_agendas(): void
    {
        [$client1, $token1] = $this->createAuthenticatedUser('client');
        [$client2]          = $this->createAuthenticatedUser('client');

        Agenda::create([
            'user_id'        => $client1->id,
            'reason'         => 'Mi agenda',
            'scheduled_date' => now()->addDays(2),
            'phone'          => '111111111',
            'active'         => true,
        ]);

        Agenda::create([
            'user_id'        => $client2->id,
            'reason'         => 'Agenda de otro',
            'scheduled_date' => now()->addDays(2),
            'phone'          => '222222222',
            'active'         => true,
        ]);

        $response = $this->withHeaders($this->authHeaders($token1))
            ->getJson('/api/agenda')
            ->assertStatus(200);

        $this->assertCount(1, $response->json());
        $this->assertEquals('Mi agenda', $response->json()[0]['reason']);
    }

    public function test_index_returns_empty_array_when_no_agendas(): void
    {
        [, $token] = $this->createAuthenticatedUser('client');

        $this->withHeaders($this->authHeaders($token))
            ->getJson('/api/agenda')
            ->assertStatus(200)
            ->assertJson([]);
    }

    // =========================================================
    // POST /api/agenda — crear agenda
    // =========================================================

    public function test_client_can_create_agenda(): void
    {
        [$user, $token] = $this->createAuthenticatedUser('client');

        $this->withHeaders($this->authHeaders($token))
            ->postJson('/api/agenda', $this->validPayload())
            ->assertStatus(201)
            ->assertJsonFragment(['reason' => 'Consulta sobre producto']);

        $this->assertDatabaseHas('agendas', [
            'user_id' => $user->id,
            'reason'  => 'Consulta sobre producto',
            'phone'   => '123456789',
            'active'  => true,
        ]);
    }

    public function test_store_fails_without_reason(): void
    {
        [, $token] = $this->createAuthenticatedUser('client');

        $this->withHeaders($this->authHeaders($token))
            ->postJson('/api/agenda', $this->validPayload(['reason' => '']))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['reason']);
    }

    public function test_store_fails_without_phone(): void
    {
        [, $token] = $this->createAuthenticatedUser('client');

        $this->withHeaders($this->authHeaders($token))
            ->postJson('/api/agenda', $this->validPayload(['phone' => '']))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
    }

    public function test_store_fails_without_scheduled_date(): void
    {
        [, $token] = $this->createAuthenticatedUser('client');

        $this->withHeaders($this->authHeaders($token))
            ->postJson('/api/agenda', $this->validPayload(['scheduled_date' => '']))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['scheduled_date']);
    }

    public function test_store_fails_with_past_date(): void
    {
        [, $token] = $this->createAuthenticatedUser('client');

        $this->withHeaders($this->authHeaders($token))
            ->postJson('/api/agenda', $this->validPayload([
                'scheduled_date' => now()->subDay()->format('Y-m-d H:i:s'),
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['scheduled_date']);
    }

    public function test_store_fails_with_invalid_date_format(): void
    {
        [, $token] = $this->createAuthenticatedUser('client');

        $this->withHeaders($this->authHeaders($token))
            ->postJson('/api/agenda', $this->validPayload(['scheduled_date' => 'no-es-una-fecha']))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['scheduled_date']);
    }

    // =========================================================
    // DELETE /api/agenda/{id} — cancelar agenda (baja lógica)
    // =========================================================

    public function test_client_can_cancel_their_own_agenda(): void
    {
        [$user, $token] = $this->createAuthenticatedUser('client');

        $agenda = Agenda::create([
            'user_id'        => $user->id,
            'reason'         => 'Cancelable',
            'scheduled_date' => now()->addDays(2),
            'phone'          => '999999999',
            'active'         => true,
        ]);

        $this->withHeaders($this->authHeaders($token))
            ->deleteJson("/api/agenda/{$agenda->id}")
            ->assertStatus(200)
            ->assertJson(['message' => 'Agenda cancelada correctamente.']);

        $this->assertDatabaseHas('agendas', [
            'id'     => $agenda->id,
            'active' => false,
        ]);
    }

    public function test_client_cannot_cancel_another_users_agenda(): void
    {
        [$owner]         = $this->createAuthenticatedUser('client');
        [, $otherToken]  = $this->createAuthenticatedUser('client');

        $agenda = Agenda::create([
            'user_id'        => $owner->id,
            'reason'         => 'Ajena',
            'scheduled_date' => now()->addDays(2),
            'phone'          => '888888888',
            'active'         => true,
        ]);

        $this->withHeaders($this->authHeaders($otherToken))
            ->deleteJson("/api/agenda/{$agenda->id}")
            ->assertStatus(422);

        $this->assertDatabaseHas('agendas', [
            'id'     => $agenda->id,
            'active' => true,
        ]);
    }

    public function test_cancel_nonexistent_agenda_returns_404(): void
    {
        [, $token] = $this->createAuthenticatedUser('client');

        $this->withHeaders($this->authHeaders($token))
            ->deleteJson('/api/agenda/99999')
            ->assertStatus(404);
    }
}
