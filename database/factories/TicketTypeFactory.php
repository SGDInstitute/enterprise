<?php

namespace Database\Factories;

use App\Models\TicketType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketTypeFactory extends Factory
{
    protected $model = TicketType::class;

    public function definition()
    {
        return [
            'name' => 'Reg Reg',
            'start' => now(),
            'end' => now()->addMonths(2),
            'timezone' => 'America/Chicago'
        ];
    }
}
