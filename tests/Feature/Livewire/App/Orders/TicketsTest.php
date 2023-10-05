<?php

namespace Tests\Feature\Livewire\App\Orders;

use App\Livewire\App\Orders\Tickets;
use App\Models\Event;
use App\Models\Order;
use App\Models\Price;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use App\Notifications\AddedToTicket;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class TicketsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_delete_ticket(): void
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
            ->assertDispatched('notify');

        $this->assertCount(4, $order->fresh()->tickets);
    }

    #[Test]
    public function cannot_delete_ticket_if_has_user(): void
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
            ->assertDispatched('notify');

        $this->assertCount(1, $order->fresh()->tickets);
    }

    #[Test]
    public function when_deleting_only_ticket_delete_order(): void
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

    #[Test]
    public function ticketholders_cannot_edit_other_tickets(): void
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
            ->assertDispatched('notify', ['message' => 'You cannot edit other tickets.', 'type' => 'error']);
    }

    #[Test]
    public function ticketholders_cannot_assign_other_tickets(): void
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
            ->assertDispatched('notify', ['message' => 'You cannot edit other tickets.', 'type' => 'error']);
    }

    #[Test]
    public function ticketholders_cannot_delete_tickets(): void
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
            ->assertDispatched('notify', ['message' => 'You cannot delete tickets.', 'type' => 'error']);
    }

    #[Test]
    public function ticketholders_cannot_remove_users_from_other_tickets(): void
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
            ->assertDispatched('notify', ['message' => 'You cannot edit other tickets.', 'type' => 'error']);
    }

    #[Test]
    public function can_invite_user_to_ticket(): void
    {
        Notification::fake();

        $event = Event::factory()->preset('mblgtacc')->create();
        $order = Order::factory()->hasTickets(3)->create();
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Tickets::class, ['order' => $order])
            ->call('loadInvite', $order->tickets->first())
            ->set('invite.email', 'adora@eternia.gov')
            ->set('invite.email_confirmation', 'adora@eternia.gov')
            ->call('inviteAttendee')
            ->assertHasNoErrors()
            ->assertSee('adora@eternia.gov');

        $this->assertDatabaseMissing('users', ['email' => 'adora@eternia.gov']);
        $this->assertDatabaseHas('invitations', [
            'invited_by' => $user->id,
            'inviteable_type' => 'App\Models\Ticket',
            'inviteable_id' => $order->tickets->first()->id,
            'email' => 'adora@eternia.gov',
        ]);

        Notification::assertSentOnDemand(AddedToTicket::class);
    }

    #[Test]
    public function can_remove_invitation_from_ticket(): void
    {
        Notification::fake();

        $event = Event::factory()->preset('mblgtacc')->create();
        $user = User::factory()->create();
        $order = Order::factory()->hasTickets(3)->for($event)->for($user)->create();
        $order->tickets->first()->invite('adora@eternia.gov', $user);

        Livewire::actingAs($user)
            ->test(Tickets::class, ['order' => $order])
            ->call('removeInviteFromTicket', $order->tickets->first()->id)
            ->assertHasNoErrors()
            ->assertDontSee('adora@eternia.gov')
            ->assertDispatched('refresh');

        $this->assertDatabaseMissing('users', ['email' => 'adora@eternia.gov']);
        $this->assertDatabaseMissing('invitations', [
            'invited_by' => $user->id,
            'inviteable_type' => 'App\Models\Ticket',
            'inviteable_id' => $order->tickets->first()->id,
            'email' => 'adora@eternia.gov',
        ]);
    }

    #[Test]
    public function can_remove_user_from_ticket()
    {
        Notification::fake();

        $event = Event::factory()->preset('mblgtacc')->create();
        $user = User::factory()->create();
        $order = Order::factory()->for($event)->for($user)->create();
        $ticket = Ticket::factory()->for($order)->for($user)->create();

        Livewire::actingAs($user)
            ->test(Tickets::class, ['order' => $order])
            ->call('removeUserFromTicket', $order->tickets->first()->id)
            ->assertHasNoErrors()
            ->assertDispatched('refresh');

        $this->assertNull($ticket->fresh()->user_id);
        $this->assertNull($ticket->fresh()->answers);
    }
}
