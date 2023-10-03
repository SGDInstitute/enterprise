<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'name' => 'Registration',
            'slots' => 2,
            'start' => now()->addHour(),
            'end' => now()->addHours(3),
            'timezone' => 'America/Chicago',
        ];
    }
}
