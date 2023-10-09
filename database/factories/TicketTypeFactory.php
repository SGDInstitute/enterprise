<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Price;
use App\Models\TicketType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Regular Registration',
            'start' => now(),
            'end' => now()->addMonths(2),
            'structure' => 'flat',
            'timezone' => 'America/Chicago',
            'event_id' => Event::factory(),
        ];
    }

    public function withPrice(): static
    {
        return $this->afterCreating(function (TicketType $ticketType) {
            Price::factory()->for($ticketType)->create();
        });
    }
}
