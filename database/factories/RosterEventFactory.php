<?php

namespace Database\Factories;

use App\Models\RosterEvent;
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
            'uuid' => fake()->uuid(),
            'activity' => fake()->word(),
            'event_type' => fake()->randomElement(RosterEvent::EVENTS),
            'arrival_location' => fake()->word(),
            'destination_location' => fake()->word(),
            'check_in' => fake()->optional()->dateTime(),
            'check_out' => fake()->optional()->dateTime(),
            'departure' => fake()->optional()->dateTime(),
            'arrival' => fake()->optional()->dateTime(),
            'event_date' => fake()->optional()->dateTime(),
        ];
    }
}
