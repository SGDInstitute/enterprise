<?php

namespace Tests\Feature\Livewire\App\Forms;

use App\Http\Livewire\App\Orders\Tickets;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_delete_ticket()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->hasPrices(2)->create();
        $order = Order::factory()
            ->for($event)
            ->hasTickets(5, [
                'ticket_type_id' => $ticketType->id,
                'price_id' => $ticketType->prices->first(),
            ])
            ->create();

        Livewire::actingAs($order->user)
            ->test(Tickets::class, ['order' => $order])
            ->assertOk()
            ->call('delete', $order->tickets->first()->id)
            ->assertEmitted('notify');

        $this->assertCount(4, $order->fresh()->tickets);
    }

    /** @test */
    public function cannot_delete_ticket_if_has_user()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->hasPrices(2)->create();
        $order = Order::factory()->for($event)->create();
        $ticket = Ticket::factory()->for($order)->create([
            'ticket_type_id' => $ticketType->id,
            'price_id' => $ticketType->prices->first(),
            'user_id' => $order->user_id,
        ]);

        Livewire::actingAs($order->user)
            ->test(Tickets::class, ['order' => $order])
            ->assertOk()
            ->call('delete', $order->tickets->first()->id)
            ->assertEmitted('notify');

        $this->assertCount(1, $order->fresh()->tickets);
    }
}
