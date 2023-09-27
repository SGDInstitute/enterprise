<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'start' => now(),
            'end' => now()->addMinutes(5),
            'timezone' => 'America/Chicago',
        ];
    }
}
