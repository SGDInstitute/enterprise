<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Order;
use App\Models\Price;
use App\Models\TicketType;
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
}
