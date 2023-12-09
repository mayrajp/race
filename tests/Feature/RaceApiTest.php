<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Race;
use App\Models\Speedway;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RaceApiTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);
    }

    public function test_index_race()
    {
        Race::factory()->count(3)->create();

        $response = $this->json('GET', '/api/race');

        $response->assertStatus(200);

        $responseData = $response->json();

        $response->assertJsonStructure(['data' => []]);

        $this->assertCount(3, $responseData['data']);
    }

    public function test_store_race()
    {
        $speedway = Speedway::factory()->create();

        $data = [
            'name' => 'Corrida 01', 
            'start_date' =>"01-01-2024 13:00:00" ,
            'end_date' => "01-01-2024 15:00:00", 
            'prize_value' => 1500.00, 
            'is_canceled' => false,
            'maximum_number_of_drivers' => 15,
            'speedway_id' => $speedway->id
        ];

        $response = $this->json('POST', '/api/race', $data);

        $response->assertStatus(201);

        $start = Carbon::create(2024, 1, 1, 13, 0, 0);
        $end = Carbon::create(2024, 1, 1, 15, 0, 0);


        $this->assertDatabaseHas('races', [
            'name' => 'Corrida 01', 
            'start_date' =>  $start,
            'end_date' => $end, 
            'prize_value' => 1500.00, 
            'is_canceled' => false,
            'maximum_number_of_drivers' => 15,
            'speedway_id' => $speedway->id
        ]);
    }

    public function test_show_race()
    {
        $speedway = Speedway::factory()->create();

        $start = Carbon::create(2024, 1, 1, 13, 0, 0);
        $end = Carbon::create(2024, 1, 1, 15, 0, 0);

        $race = Race::factory()->create([
            'name' => 'Corrida 01', 
            'start_date' => $start ,
            'end_date' =>  $end, 
            'prize_value' => 1500.00, 
            'is_canceled' => false,
            'maximum_number_of_drivers' => 15,
            'speedway_id' => $speedway->id
        ]);

        $response = $this->json('GET', '/api/race/' . $race->id);
        $response->assertStatus(200);

        $this->assertEquals('Corrida 01', $response['data']['name']);
        $this->assertEquals($start, $response['data']['start_date']);
        $this->assertEquals(1500.00, $response['data']['prize_value']);
        $this->assertEquals(false, $response['data']['is_canceled']);
        $this->assertEquals($end, $response['data']['end_date']);
        $this->assertEquals(15, $response['data']['maximum_number_of_drivers']);
        $this->assertEquals($speedway->id, $response['data']['speedway_id']);
    }

    public function test_can_update_race()
    {
        $speedway = Speedway::factory()->create();

        $start = Carbon::create(2024, 1, 1, 13, 0, 0);
        $end = Carbon::create(2024, 1, 1, 15, 0, 0);

        $race = Race::factory()->create([
            'name' => 'Corrida 01', 
            'start_date' => $start ,
            'end_date' =>  $end, 
            'prize_value' => 1500.00, 
            'is_canceled' => false,
            'maximum_number_of_drivers' => 15,
            'speedway_id' => $speedway->id
        ]);

        $data = [
            'name' => 'Corrida 02', 
            'start_date' =>"01-01-2024 13:00:00" ,
            'end_date' => "01-01-2024 15:00:00", 
            'prize_value' => 1500.00, 
            'is_canceled' => false,
            'maximum_number_of_drivers' => 10,
            'speedway_id' => $speedway->id
        ];

        $response = $this->json('PUT', '/api/race/' . $race->id, $data);

        $response->assertStatus(200);

        $this->assertEquals('Corrida 02', $response['data']['name']);
        $this->assertEquals($start, $response['data']['start_date']);
        $this->assertEquals(1500.00, $response['data']['prize_value']);
        $this->assertEquals(false, $response['data']['is_canceled']);
        $this->assertEquals($end, $response['data']['end_date']);
        $this->assertEquals(10, $response['data']['maximum_number_of_drivers']);
        $this->assertEquals($speedway->id, $response['data']['speedway_id']);
    }

    public function test_can_cancel_race()
    {
        $speedway = Speedway::factory()->create();

        $start = Carbon::create(2024, 1, 1, 13, 0, 0);
        $end = Carbon::create(2024, 1, 1, 15, 0, 0);

        $race = Race::factory()->create([
            'name' => 'Corrida 01', 
            'start_date' => $start ,
            'end_date' =>  $end, 
            'prize_value' => 1500.00, 
            'is_canceled' => false,
            'maximum_number_of_drivers' => 15,
            'speedway_id' => $speedway->id
        ]);

        $response = $this->json('POST', '/api/race/cancel/' . $race->id);

        $response->assertStatus(200);

         $this->assertDatabaseHas('races', [
            'id' => $race->id,
            'is_canceled' => true,
        ]);
    }

    public function test_cant_create_race_with_speedway_in_maintenance()
    {
        $speedway = Speedway::factory()->create([
            'name' => 'Rally',
            'in_maintenance' => true,
            'type' => 'Rally Courses',
            'is_active' => true,

        ]);

        $data = [
            'name' => 'Corrida 01', 
            'start_date' =>"01-01-2024 13:00:00" ,
            'end_date' => "01-01-2024 15:00:00", 
            'prize_value' => 1500.00, 
            'is_canceled' => false,
            'maximum_number_of_drivers' => 15,
            'speedway_id' => $speedway->id
        ];

        $response = $this->json('POST', '/api/race', $data);

        $response->assertStatus(400);

        $this->assertEquals('Pista de corrida encontra-se indisponível.', $response['data']['error']);
    }

    public function test_cant_create_race_with_speedway_inactive()
    {
        $speedway = Speedway::factory()->create([
            'name' => 'Rally',
            'in_maintenance' => false,
            'type' => 'Rally Courses',
            'is_active' => false,

        ]);

        $data = [
            'name' => 'Corrida 01', 
            'start_date' =>"01-01-2024 13:00:00" ,
            'end_date' => "01-01-2024 15:00:00", 
            'prize_value' => 1500.00, 
            'is_canceled' => false,
            'maximum_number_of_drivers' => 15,
            'speedway_id' => $speedway->id
        ];

        $response = $this->json('POST', '/api/race', $data);

        $response->assertStatus(400);

        $this->assertEquals('Pista de corrida encontra-se indisponível.', $response['data']['error']);
    }

    public function test_can_attach_driver()
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

         $speedway = Speedway::factory()->create([
            'name' => 'Rally',
            'in_maintenance' => false,
            'type' => 'Street Circuits',
            'is_active' => true,

        ]);

        $start = Carbon::create(2024, 1, 1, 13, 0, 0);
        $end = Carbon::create(2024, 1, 1, 15, 0, 0);

        $race = Race::factory()->create([
            'name' => 'Corrida 01', 
            'start_date' => $start ,
            'end_date' =>  $end, 
            'prize_value' => 1500.00, 
            'is_canceled' => false,
            'maximum_number_of_drivers' => 15,
            'speedway_id' => $speedway->id
        ]);

        $data= [
            "race_id" => $race->id,
            "drivers" => [$driver->id]
        ];

        $response = $this->json('POST', '/api/race/attach/drivers/', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('race_drivers', [
            'driver_id' => $driver->id,
            'race_id' => $race->id,
        ]);

    }

    public function test_cant_attach_driver()
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

         $speedway = Speedway::factory()->create([
            'name' => 'Rally',
            'in_maintenance' => false,
            'type' => 'Karting Tracks',
            'is_active' => true,

        ]);

        $start = Carbon::create(2024, 1, 1, 13, 0, 0);
        $end = Carbon::create(2024, 1, 1, 15, 0, 0);

        $race = Race::factory()->create([
            'name' => 'Corrida 01', 
            'start_date' => $start ,
            'end_date' =>  $end, 
            'prize_value' => 1500.00, 
            'is_canceled' => false,
            'maximum_number_of_drivers' => 15,
            'speedway_id' => $speedway->id
        ]);

        $data= [
            "race_id" => $race->id,
            "drivers" => [$driver->id]
        ];

        $response = $this->json('POST', '/api/race/attach/drivers/', $data);

        $response->assertStatus(500);

        $this->assertEquals('Competidor '.$driver->name.' não tem veículo adequado para a pista.', $response['data']['error']);

    }
    
}