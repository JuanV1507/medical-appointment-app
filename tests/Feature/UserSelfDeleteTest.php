<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSelfDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_usuario_no_puede_eliminarse_a_si_mismo()
    {
        // Crear usuario
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        // Loguearse como ese usuario
        $this->actingAs($user, 'web');

        // Intentar eliminarse
        $response = $this->delete(route('admin.users.destroy', $user));

        // Debe bloquear
        $response->assertStatus(403);

        // El usuario sigue existiendo
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }
}