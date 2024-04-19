<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RosterEvent>
 */
class RosterEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_type' => fake()->word(),
            'flight_number' => fake()->word(),
            'departure' => fake()->dateTime(),
            'arrival' => fake()->dateTime(),
            'location' => fake()->word(),
        ];
    }
}
