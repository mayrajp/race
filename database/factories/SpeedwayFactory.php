<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Speedway>
 */
class SpeedwayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'in_maintenance' => $this->faker->boolean,
            'type' => 'Rally Courses',
            'is_active' => $this->faker->boolean,
        ];
    }
}
