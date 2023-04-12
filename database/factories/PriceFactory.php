<?php

namespace Database\Factories;

use App\Models\TicketType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'In-person',
            'cost' => 1000,
            'ticket_type_id' => TicketType::factory(),
        ];
    }
}
