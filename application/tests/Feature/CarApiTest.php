<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarApiTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);
    }

    public function test_index_car()
    {
        Car::factory()->count(3)->create();

        $response = $this->json('GET', '/api/car');

        $response->assertStatus(200);

        $responseData = $response->json();

        $response->assertJsonStructure(['data' => []]);

        $this->assertCount(3, $responseData['data']);
    }

    public function test_store_car()
    {
        $driver = Driver::factory()->create();

        $data = [
            "model" => "corolla",
            "brand" => "toyota",
            "year" => 2019,
            "color" => "black",
            "speedway_types" => ['Street Circuits'],
            "driver_id" => $driver->id
        ];

        $response = $this->json('POST', '/api/car', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('cars', [
            'model' => 'corolla',
            'brand' => 'toyota',
            'year' => 2019,
            'color' => 'black',
            'speedway_types' => $this->castAsJson(['Street Circuits']),
            'driver_id' => $driver->id
        ]);
    }

    public function test_show_car()
    {
        $driver = Driver::factory()->create();

        $car = Car::factory()->create([
            "model" => "corolla",
            "brand" => "toyota",
            "year" => 2019,
            "color" => "black",
            "speedway_types" => json_encode(['Street Circuits']),
            "driver_id" => $driver->id
        ]);

        $response = $this->json('GET', '/api/car/' . $car->id);
        $response->assertStatus(200);

        $this->assertEquals('corolla', $response['data']['model']);
        $this->assertEquals("toyota", $response['data']['brand']);
        $this->assertEquals(2019, $response['data']['year']);
        $this->assertEquals(json_encode(['Street Circuits']), $response['data']['speedway_types']);
        $this->assertEquals($driver->id, $response['data']['driver_id']);
    }

    public function test_can_update_car()
    {
        $driver = Driver::factory()->create();

        $car = Car::factory()->create([
            "model" => "corolla",
            "brand" => "toyota",
            "year" => 2019,
            "color" => "black",
            "speedway_types" => json_encode(['Street Circuits']),
            "driver_id" => $driver->id
        ]);

        $data = [
            "model" => "corsa",
            "brand" => "chevrolet",
            "year" => 2000,
            "color" => "black",
            "speedway_types" => ['Street Circuits'],
            "driver_id" => $driver->id
        ];

        $response = $this->json('PUT', '/api/car/' . $car->id, $data);

        $response->assertStatus(200);

        $this->assertEquals('corsa', $response['data']['model']);
        $this->assertEquals("chevrolet", $response['data']['brand']);
        $this->assertEquals(2000, $response['data']['year']);
        $this->assertEquals(json_encode(['Street Circuits']), $response['data']['speedway_types']);
        $this->assertEquals($driver->id, $response['data']['driver_id']);
    }

    public function test_delete_car()
    {
        $car =  Car::factory()->create();

        $response = $this->deleteJson('/api/car/' . $car->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('cars', ['id' => $car->id]);
    }
}
