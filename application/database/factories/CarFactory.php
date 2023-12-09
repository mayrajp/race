<?php

namespace Database\Factories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $driver =  Driver::factory()->create();
        return [
            "model" => $this->faker->word,
            "brand" => $this->faker->word,
            "year"  => $this->faker->numerify('####'),
            "color" => $this->faker->colorName,
            "speedway_types" => json_encode(['Road Courses',"Rally Courses"]),
            'driver_id' => $driver->id,
        ];
    }
}
