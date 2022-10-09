<?php

namespace Tests\Feature\Livewire\App\Orders;

use App\Http\Livewire\App\Orders\Show;
use App\Models\Event;
use App\Models\Order;
use App\Models\Price;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_delete_order_if_unpaid()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->create(['amount' => 8500]);
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

    /** @test */
    public function ticketholders_are_redirected_to_tickets_tab()
    {
        // todo
    }

    /** @test */
    public function ticketholders_can_view_orders()
    {
        // todo
    }

    /** @test */
    public function ticketholders_can_view_reservations()
    {
        // todo
    }

    /** @test */
    public function ticketholders_cannot_edit_other_tickets()
    {
        // todo
    }

    /** @test */
    public function ticketholders_cannot_view_start_tab()
    {
        // todo
    }

    /** @test */
    public function ticketholders_cannot_view_payment_tab()
    {
        // todo
    }

    /** @test */
    public function users_cannot_view_orders_they_are_not_attached_to()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->create(['amount' => 8500]);
        $ticket = Ticket::factory()->for($order)->create([
            'ticket_type_id' => $ticketType->id,
            'price_id' => $price->id,
        ]);

        Livewire::actingAs(User::factory()->create())
            ->test(Show::class, ['order' => $order])
            ->assertForbidden();
    }
}
