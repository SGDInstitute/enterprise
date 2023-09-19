<?php

namespace Tests\Feature\Livewire\App\Orders;

use PHPUnit\Framework\Attributes\Test;
use App\Livewire\App\Orders\Show;
use App\Models\Event;
use App\Models\Order;
use App\Models\Price;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

final class ShowTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_delete_order_if_unpaid(): void
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->create(['id' => 123, 'amount' => 8500]);
        $ticket = Ticket::factory()->for($order)->create([
            'ticket_type_id' => $ticketType->id,
            'price_id' => $price->id,
        ]);

        Livewire::actingAs($order->user)
            ->test(Show::class, ['order' => $order])
            ->assertOk()
            ->call('delete')
            ->assertRedirect();

        $this->assertSoftDeleted($order);
    }

    #[Test]
    public function ticketholders_can_view_orders(): void
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->paid()->create(['id' => 124, 'amount' => 8500]); // need ID for stripe
        $ticket = Ticket::factory()->for($order)->for($ticketType)->for($price)->for(User::factory())->create();
        Ticket::factory()->for($order)->for($ticketType)->for($price)->create();

        Livewire::actingAs($ticket->user)
            ->test(Show::class, ['order' => $order])
            ->assertOk();
    }

    #[Test]
    public function ticketholders_can_view_reservations(): void
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $reservation = Order::factory()->for($event)->create(['id' => 125, 'amount' => 8500]);
        $ticket = Ticket::factory()->for($reservation)->for($ticketType)->for($price)->for(User::factory())->create();
        Ticket::factory()->for($reservation)->for($ticketType)->for($price)->create();

        Livewire::actingAs($ticket->user)
            ->test(Show::class, ['order' => $reservation])
            ->assertOk();
    }

    #[Test]
    public function ticketholders_are_shown_tickets_tab(): void
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->paid()->create(['amount' => 8500]);
        $ticket = Ticket::factory()->for($order)->for($ticketType)->for($price)->for(User::factory())->create();

        Livewire::actingAs($ticket->user)
            ->test(Show::class, ['order' => $order])
            ->assertSet('page', 'attendee');
    }

    #[Test]
    public function ticketholders_cannot_view_start_tab(): void
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->paid()->create(['amount' => 8500]);
        $ticket = Ticket::factory()->for($order)->for($ticketType)->for($price)->for(User::factory())->create();

        Livewire::actingAs($ticket->user)
            ->test(Show::class, ['order' => $order, 'page' => 'start'])
            ->assertSet('page', 'attendee');
    }

    #[Test]
    public function ticketholders_cannot_view_payment_tab(): void
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->paid()->create(['amount' => 8500]);
        $ticket = Ticket::factory()->for($order)->for($ticketType)->for($price)->for(User::factory())->create();

        Livewire::actingAs($ticket->user)
            ->test(Show::class, ['order' => $order, 'page' => 'payment'])
            ->assertSet('page', 'attendee');
    }

    #[Test]
    public function users_cannot_view_orders_they_are_not_attached_to(): void
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->paid()->create(['amount' => 8500]);
        $ticket = Ticket::factory()->for($order)->create([
            'ticket_type_id' => $ticketType->id,
            'price_id' => $price->id,
        ]);

        Livewire::actingAs(User::factory()->create())
            ->test(Show::class, ['order' => $order])
            ->assertForbidden();
    }
}
