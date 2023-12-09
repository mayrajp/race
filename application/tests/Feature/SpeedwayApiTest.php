<?php

namespace Tests\Feature;

use App\Models\Speedway;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpeedwayApiTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_index_speedway()
    {
         Speedway::factory()->count(3)->create();

         $response = $this->json('GET', '/api/speedway');
 
         $response->assertStatus(200);
 
         $responseData = $response->json();
 
         $response->assertJsonStructure(['data' => []]);
 
         $this->assertCount(3, $responseData['data']);
    }

    public function test_store_speedway()
    {
        $data = [
            "name" => "Pista 02",
            "in_maintenance" => false,
            "type" => "Rally Courses",
            "is_active" => true
        ];

        $response = $this->json('POST', '/api/speedway', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('speedways', $data);

    }

    public function test_show_speedways()
    {
        $speedways = Speedway::factory()->create([
            'name' => 'Rally',
            'in_maintenance' => false,
            'type' => 'Rally Courses',
            'is_active' => true,

        ]);


        $response = $this->json('GET', '/api/speedway/'.$speedways->id);
        $response->assertStatus(200);

        $this->assertEquals('Rally', $response['data']['name']);
        $this->assertEquals(false,$response['data']['in_maintenance']);
        $this->assertEquals('Rally Courses',$response['data']['type']);
        $this->assertEquals(true, $response['data']['is_active']);

    }

    public function test_can_update_speedway()
    {
        $speedways = Speedway::factory()->create([
            'name' => 'Rally',
            'in_maintenance' => false,
            'type' => 'Rally Courses',
            'is_active' => true,

        ]);

        $data = [
            "name" => "Pista 999",
            "in_maintenance" => false,
            "type" => "Rally Courses",
            "is_active" => true
        ];

        $response = $this->json('PUT', '/api/speedway/'.$speedways->id, $data);

        $response->assertStatus(200);

        $this->assertEquals('Pista 999', $response['data']['name']);
        $this->assertEquals(false,$response['data']['in_maintenance']);
        $this->assertEquals('Rally Courses',$response['data']['type']);
        $this->assertEquals(true, $response['data']['is_active']);
    }
}
