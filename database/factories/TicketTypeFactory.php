<?php

namespace Database\Factories;

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
        ];
    }
}
