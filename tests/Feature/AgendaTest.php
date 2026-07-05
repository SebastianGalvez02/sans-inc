<?php

namespace Tests\Feature;

use App\Models\Agenda;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgendaTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================
    // Helpers
    // =========================================================

    private function createRole(string $name): Role
    {
        return Role::create(['role_name' => $name, 'description' => $name]);
    }

    private function createUser(string $roleName): User
    {
        $role = Role::firstOrCreate(
            ['role_name' => $roleName],
            ['description' => $roleName]
        );

        return User::factory()->create(['role_id' => $role->id]);
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
        $this->getJson('/agenda')->assertStatus(401);
    }

    public function test_non_client_user_cannot_access_agenda(): void
    {
        $user = $this->createUser('user');

        $this->actingAs($user)
            ->getJson('/agenda')
            ->assertStatus(403)
            ->assertJson(['message' => 'Acceso restringido a clientes.']);
    }

    public function test_client_user_can_access_agenda(): void
    {
        $user = $this->createUser('client');

        $this->actingAs($user)
            ->getJson('/agenda')
            ->assertStatus(200);
    }

    // =========================================================
    // GET /agenda — listar agendas del usuario
    // =========================================================

    public function test_client_sees_only_their_own_agendas(): void
    {
        $client1 = $this->createUser('client');
        $client2 = $this->createUser('client');

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

        $response = $this->actingAs($client1)
            ->getJson('/agenda')
            ->assertStatus(200);

        $this->assertCount(1, $response->json());
        $this->assertEquals('Mi agenda', $response->json()[0]['reason']);
    }

    public function test_index_returns_empty_array_when_no_agendas(): void
    {
        $user = $this->createUser('client');

        $this->actingAs($user)
            ->getJson('/agenda')
            ->assertStatus(200)
            ->assertJson([]);
    }

    // =========================================================
    // POST /agenda — crear agenda
    // =========================================================

    public function test_client_can_create_agenda(): void
    {
        $user = $this->createUser('client');

        $this->actingAs($user)
            ->postJson('/agenda', $this->validPayload())
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
        $user = $this->createUser('client');

        $this->actingAs($user)
            ->postJson('/agenda', $this->validPayload(['reason' => '']))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['reason']);
    }

    public function test_store_fails_without_phone(): void
    {
        $user = $this->createUser('client');

        $this->actingAs($user)
            ->postJson('/agenda', $this->validPayload(['phone' => '']))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
    }

    public function test_store_fails_without_scheduled_date(): void
    {
        $user = $this->createUser('client');

        $this->actingAs($user)
            ->postJson('/agenda', $this->validPayload(['scheduled_date' => '']))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['scheduled_date']);
    }

    public function test_store_fails_with_past_date(): void
    {
        $user = $this->createUser('client');

        $this->actingAs($user)
            ->postJson('/agenda', $this->validPayload([
                'scheduled_date' => now()->subDay()->format('Y-m-d H:i:s'),
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['scheduled_date']);
    }

    public function test_store_fails_with_invalid_date_format(): void
    {
        $user = $this->createUser('client');

        $this->actingAs($user)
            ->postJson('/agenda', $this->validPayload(['scheduled_date' => 'no-es-una-fecha']))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['scheduled_date']);
    }

    // =========================================================
    // DELETE /agenda/{id} — cancelar agenda (baja lógica)
    // =========================================================

    public function test_client_can_cancel_their_own_agenda(): void
    {
        $user = $this->createUser('client');

        $agenda = Agenda::create([
            'user_id'        => $user->id,
            'reason'         => 'Cancelable',
            'scheduled_date' => now()->addDays(2),
            'phone'          => '999999999',
            'active'         => true,
        ]);

        $this->actingAs($user)
            ->deleteJson("/agenda/{$agenda->id}")
            ->assertStatus(200)
            ->assertJson(['message' => 'Agenda cancelada correctamente.']);

        $this->assertDatabaseHas('agendas', [
            'id'     => $agenda->id,
            'active' => false,
        ]);
    }

    public function test_client_cannot_cancel_another_users_agenda(): void
    {
        $owner  = $this->createUser('client');
        $other  = $this->createUser('client');

        $agenda = Agenda::create([
            'user_id'        => $owner->id,
            'reason'         => 'Ajena',
            'scheduled_date' => now()->addDays(2),
            'phone'          => '888888888',
            'active'         => true,
        ]);

        $this->actingAs($other)
            ->deleteJson("/agenda/{$agenda->id}")
            ->assertStatus(422);

        $this->assertDatabaseHas('agendas', [
            'id'     => $agenda->id,
            'active' => true,
        ]);
    }

    public function test_cancel_nonexistent_agenda_returns_404(): void
    {
        $user = $this->createUser('client');

        $this->actingAs($user)
            ->deleteJson('/agenda/99999')
            ->assertStatus(404);
    }
}
