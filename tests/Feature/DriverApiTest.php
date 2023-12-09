<?php

namespace Tests\Feature;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DriverApiTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);
    }


    public function test_index_driver()
    {
        Driver::factory()->count(3)->create();

        $response = $this->json('GET', '/api/driver');

        $response->assertStatus(200);

        $responseData = $response->json();

        $response->assertJsonStructure(['data' => []]);

        $this->assertCount(3, $responseData['data']);
    }

    public function test_store_driver()
    {
        $data = [
            "name" => "Julia",
            "document" => "12345678909",
            "number" => 123,
            "is_active" => true
        ];

        $response = $this->json('POST', '/api/driver', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('drivers', $data);
    }

    public function test_show_driver()
    {
        $driver = Driver::factory()->create([
            "name" => "Julia",
            "document" => "12345678909",
            "number" => 123,
            "is_active" => true

        ]);


        $response = $this->json('GET', '/api/driver/'.$driver->id);
        $response->assertStatus(200);

        $this->assertEquals('Julia', $response['data']['name']);
        $this->assertEquals( "12345678909",$response['data']['document']);
        $this->assertEquals(123,$response['data']['number']);
        $this->assertEquals(true, $response['data']['is_active']);

    }

    public function test_can_update_driver()
    {
        $driver = Driver::factory()->create([
            "name" => "Julia",
            "document" => "12345678909",
            "number" => 123,
            "is_active" => true
        ]);


        $data = [
            "name" => "Maria",
            "document" => "12345678909",
            "number" => 123,
            "is_active" => true
        ];

        $response = $this->json('PUT', '/api/driver/'.$driver->id, $data);

        $response->assertStatus(200);

        $this->assertEquals('Maria', $response['data']['name']);
        $this->assertEquals( "12345678909",$response['data']['document']);
        $this->assertEquals(123,$response['data']['number']);
        $this->assertEquals(true, $response['data']['is_active']);
    }

}
