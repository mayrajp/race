<?php

namespace Database\Factories;

use App\Models\Speedway;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Race>
 */
class RaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $speedway = Speedway::factory()->create();
        
        return [
            'name' =>$this->faker->word, 
            'start_date' => $this->faker->dateTime,
            'end_date' => $this->faker->dateTime, 
            'prize_value' => 1500.00, 
            'is_canceled' => false,
            'maximum_number_of_drivers' => 15,
            'speedway_id' => $speedway->id
        ];
    }
}
