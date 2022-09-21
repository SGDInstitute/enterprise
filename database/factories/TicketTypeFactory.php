<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketTypeFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => 'Reg Reg',
            'start' => now(),
            'end' => now()->addMonths(2),
            'timezone' => 'America/Chicago',
            'event_id' => Event::factory(),
        ];
    }
}
