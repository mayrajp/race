<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterApiTest extends TestCase
{

    use RefreshDatabase;

    public function test_can_register_user()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Mayra',
            'email' => 'mayra@example.com',
            'password' => '1234',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => 'Mayra',
            'email' => 'mayra@example.com',
        ]);
    }

    public function test_can_login()
    {
        $user = User::factory()->create([
            'email' => 'mayra@example.com',
            'password' => Hash::make('1234'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'mayra@example.com',
            'password' => '1234',
        ]);

        $response->assertStatus(200);
        
        $this->assertAuthenticated();
    }
}
