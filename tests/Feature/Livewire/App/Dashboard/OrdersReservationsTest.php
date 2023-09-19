<?php

namespace Tests\Feature\Livewire\App\Dashboard;

use PHPUnit\Framework\Attributes\Test;
use App\Livewire\App\Dashboard\OrdersReservations;
use App\Models\Event;
use App\Models\Order;
use App\Models\Price;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OrdersReservationsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_view_all_orders(): void
    {
        $user = User::factory()->create();
        Order::factory()->for($user)->paid()->create();

        Livewire::actingAs($user)
            ->test(OrdersReservations::class)
            ->assertCount('orders', 1)
            ->assertCount('reservations', 0);
    }

    #[Test]
    public function can_view_all_reservations(): void
    {
        $user = User::factory()->create();
        Order::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(OrdersReservations::class)
            ->assertCount('orders', 0)
            ->assertCount('reservations', 1);
    }

    #[Test]
    public function ticketholder_can_view_order(): void
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->paid()->create(['amount' => 8500]);
        $ticket = Ticket::factory()->for($order)->for($ticketType)->for($price)->for(User::factory())->create();

        Livewire::actingAs($ticket->user)
            ->test(OrdersReservations::class)
            ->assertCount('orders', 1)
            ->assertCount('reservations', 0);
    }

    #[Test]
    public function ticketholder_can_view_reservation(): void
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->create(['amount' => 8500]);
        $ticket = Ticket::factory()->for($order)->for($ticketType)->for($price)->for(User::factory())->create();

        Livewire::actingAs($ticket->user)
            ->test(OrdersReservations::class)
            ->assertCount('orders', 0)
            ->assertCount('reservations', 1);
    }
}
