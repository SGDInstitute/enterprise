<?php

namespace Tests\Feature\Livewire\App\Orders;

use App\Http\Livewire\App\Orders\Tickets;
use App\Models\Event;
use App\Models\Order;
use App\Models\Price;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

    /** @test */
    public function when_deleting_only_ticket_delete_order()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->hasPrices(2)->create();
        $order = Order::factory()->for($event)->create();
        $ticket = Ticket::factory()->for($order)->create([
            'ticket_type_id' => $ticketType->id,
            'price_id' => $ticketType->prices->first(),
        ]);

        Livewire::actingAs($order->user)
            ->test(Tickets::class, ['order' => $order])
            ->assertOk()
            ->call('delete', $order->tickets->first()->id)
            ->assertRedirect();

        $this->assertSoftDeleted($order);
    }

    /** @test */
    public function ticketholders_cannot_edit_other_tickets()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->create();
        $luz = User::factory()->create(['name' => 'Luz Noceda']);
        $amity = User::factory()->create(['name' => 'Amity Blight']);
        $tickets = Ticket::factory()
            ->for($order)
            ->for($ticketType)
            ->for($price)
            ->state(new Sequence(
                ['user_id' => $luz->id],
                ['user_id' => $amity->id],
            ))
            ->count(2)
            ->create();

        Livewire::actingAs($amity)
            ->test(Tickets::class, ['order' => $order])
            ->assertOk()
            ->call('loadTicket', $tickets->first()->id)
            ->assertEmitted('notify', ['message' => "You cannot edit other tickets.", 'type' => 'error']);
    }

    /** @test */
    public function ticketholders_cannot_assign_other_tickets()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->create();
        $luz = User::factory()->create(['name' => 'Luz Noceda']);
        $tickets = Ticket::factory()
            ->for($order)
            ->for($ticketType)
            ->for($price)
            ->state(new Sequence(
                ['user_id' => null],
                ['user_id' => $luz->id],
            ))
            ->count(2)
            ->create();

        Livewire::actingAs($luz)
            ->test(Tickets::class, ['order' => $order])
            ->assertOk()
            ->call('loadTicket', $tickets->first()->id)
            ->assertEmitted('notify', ['message' => "You cannot edit other tickets.", 'type' => 'error']);
    }

    /** @test */
    public function ticketholders_cannot_delete_tickets()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->create();
        $luz = User::factory()->create(['name' => 'Luz Noceda']);
        $amity = User::factory()->create(['name' => 'Amity Blight']);
        $tickets = Ticket::factory()
            ->for($order)
            ->for($ticketType)
            ->for($price)
            ->state(new Sequence(
                ['user_id' => $luz->id],
                ['user_id' => $amity->id],
            ))
            ->count(2)
            ->create();

        Livewire::actingAs($amity)
            ->test(Tickets::class, ['order' => $order])
            ->assertOk()
            ->call('delete', $tickets->first()->id)
            ->assertEmitted('notify', ['message' => "You cannot delete tickets.", 'type' => 'error']);
    }

    /** @test */
    public function ticketholders_cannot_remove_users_from_other_tickets()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create(['cost' => 8500]);
        $order = Order::factory()->for($event)->create();
        $luz = User::factory()->create(['name' => 'Luz Noceda']);
        $amity = User::factory()->create(['name' => 'Amity Blight']);
        $tickets = Ticket::factory()
            ->for($order)
            ->for($ticketType)
            ->for($price)
            ->state(new Sequence(
                ['user_id' => $luz->id],
                ['user_id' => $amity->id],
            ))
            ->count(2)
            ->create();

        Livewire::actingAs($amity)
            ->test(Tickets::class, ['order' => $order])
            ->assertOk()
            ->call('removeUserFromTicket', $tickets->first()->id)
            ->assertEmitted('notify', ['message' => "You cannot edit other tickets.", 'type' => 'error']);
    }
}
