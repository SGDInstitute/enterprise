<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Order;
use App\Models\Price;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'order_id' => Order::factory(),
            'ticket_type_id' => TicketType::factory(),
            'price_id' => Price::factory(),
        ];
    }

    public function completed(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'user_id' => User::factory(),
            ];
        });
    }

    public function invited(): static
    {
        return $this->afterCreating(function (Ticket $ticket) {
            $ticket->invite(fake()->safeEmail(), User::factory()->create());
        });
    }
}
