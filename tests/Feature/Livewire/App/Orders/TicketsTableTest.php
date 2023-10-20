<?php

namespace Tests\Feature\Livewire\App\Orders;

use App\Livewire\App\Orders\TicketsTable;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\AcceptInviteReminder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TicketsTableTest extends TestCase
{
    use RefreshDatabase;

    // General rows

    #[Test]
    public function can_see_tickets_for_order()
    {
        $order = Order::factory()->create();
        $tickets = Ticket::factory()->for($order)->count(3)->create();

        Livewire::test(TicketsTable::class, ['order' => $order])
            ->assertCanSeeTableRecords($tickets)
            ->assertCountTableRecords(3);
    }

    #[Test]
    public function cannot_see_tickets_for_another_order()
    {
        $order = Order::factory()->create();
        $tickets = Ticket::factory()->count(3)->create();

        Livewire::test(TicketsTable::class, ['order' => $order])
            ->assertCanNotSeeTableRecords($tickets)
            ->assertCountTableRecords(0);
    }

    #[Test]
    public function can_invitation_email_in_email_column()
    {
        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        $ticketA = Ticket::factory()->for($order)->for($luffy)->create();
        $ticketB = Ticket::factory()->for($order)->create();
        $ticketB->invite('zoro@strawhat.pirate', $luffy);

        Livewire::test(TicketsTable::class, ['order' => $order])
            ->assertTableColumnFormattedStateSet('user.email', 'luffy@strawhat.pirate', record: $ticketA)
            ->assertTableColumnFormattedStateSet('user.email', 'zoro@strawhat.pirate', record: $ticketB);
    }

    // Row actions

    #[Test]
    public function can_invite_user_to_individual_ticket()
    {
        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        $ticket = Ticket::factory()->for($order)->create();

        Livewire::actingAs($luffy)
            ->test(TicketsTable::class, ['order' => $order])
            ->callTableAction('invite', $ticket, data: [
                'email' => 'zoro@strawhat.pirate',
                'email_confirmation' => 'zoro@strawhat.pirate',
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('invitations', [
            'invited_by' => $luffy->id,
            'inviteable_type' => "App\Models\Ticket",
            'inviteable_id' => $ticket->id,
            'email' => 'zoro@strawhat.pirate',
        ]);
    }

    #[Test]
    public function cannot_invite_if_existing_invitation()
    {
        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        $ticket = Ticket::factory()->for($order)->create();
        $ticket->invite('zoro@strawhat.pirate', $luffy);

        Livewire::actingAs($luffy)
            ->test(TicketsTable::class, ['order' => $order])
            ->assertTableActionHidden('invite', $ticket);
    }

    #[Test]
    public function cannot_invite_if_existing_user()
    {
        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        $ticket = Ticket::factory()->for($order)->for($luffy)->create();

        Livewire::actingAs($luffy)
            ->test(TicketsTable::class, ['order' => $order])
            ->assertTableActionHidden('invite', $ticket);
    }

    #[Test]
    public function can_remove_invitation_from_ticket()
    {
        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        $ticket = Ticket::factory()->for($order)->create();
        $ticket->invite('zoro@strawhat.pirate', $luffy);

        Livewire::actingAs($luffy)
            ->test(TicketsTable::class, ['order' => $order])
            ->callTableAction('remove-invite', $ticket)
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('invitations', [
            'invited_by' => $luffy->id,
            'inviteable_type' => "App\Models\Ticket",
            'inviteable_id' => $ticket->id,
            'email' => 'zoro@strawhat.pirate',
        ]);
    }

    #[Test]
    public function cannot_remove_invitation_if_existing_user()
    {
        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        $ticket = Ticket::factory()->for($order)->for($luffy)->create();

        Livewire::actingAs($luffy)
            ->test(TicketsTable::class, ['order' => $order])
            ->assertTableActionHidden('remove-invite', $ticket);
    }

    #[Test]
    public function cannot_remove_invitation_if_no_invitation()
    {
        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        $ticket = Ticket::factory()->for($order)->create();

        Livewire::actingAs($luffy)
            ->test(TicketsTable::class, ['order' => $order])
            ->assertTableActionHidden('remove-invite', $ticket);
    }

    #[Test]
    public function can_remove_user_from_ticket()
    {
        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        $ticket = Ticket::factory()->for($order)->for($luffy)->create();

        Livewire::actingAs($luffy)
            ->test(TicketsTable::class, ['order' => $order])
            ->callTableAction('remove-user', $ticket)
            ->assertHasNoActionErrors();

        $this->assertNull($ticket->fresh()->user);
    }

    #[Test]
    public function cannot_remove_user_if_no_user()
    {
        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        $ticket = Ticket::factory()->for($order)->create();

        Livewire::actingAs($luffy)
            ->test(TicketsTable::class, ['order' => $order])
            ->assertTableActionHidden('remove-user', $ticket);
    }

    #[Test]
    public function can_remind_invitee_to_accept()
    {
        Notification::fake();

        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        $ticket = Ticket::factory()->for($order)->create();
        $ticket->invite('zoro@strawhat.pirate', $luffy);

        Livewire::actingAs($luffy)
            ->test(TicketsTable::class, ['order' => $order])
            ->callTableAction('remind-invite', $ticket)
            ->assertHasNoActionErrors();

        Notification::assertSentOnDemand(AcceptInviteReminder::class);
    }

    #[Test]
    public function cannot_remind_user_to_accept_invite()
    {
        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        $ticket = Ticket::factory()->for($order)->for($luffy)->create();

        Livewire::actingAs($luffy)
            ->test(TicketsTable::class, ['order' => $order])
            ->assertTableActionHidden('remind-invite', $ticket);
    }

    #[Test]
    public function cannot_remind_unassigned_ticket_to_accept()
    {
        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        $ticket = Ticket::factory()->for($order)->create();

        Livewire::actingAs($luffy)
            ->test(TicketsTable::class, ['order' => $order])
            ->assertTableActionHidden('remind-invite', $ticket);
    }

    #[Test]
    public function can_add_self_to_ticket()
    {
        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        $ticket = Ticket::factory()->for($order)->create();

        Livewire::actingAs($luffy)
            ->test(TicketsTable::class, ['order' => $order])
            ->callTableAction('add-self', $ticket)
            ->assertHasNoActionErrors();

        $this->assertEquals($luffy->id, $ticket->fresh()->user_id);
    }

    #[Test]
    public function cannot_add_self_to_ticket_if_already_on_order()
    {
        $order = Order::factory()->create();
        $luffy = User::factory()->create(['email' => 'luffy@strawhat.pirate']);
        Ticket::factory()->for($order)->for($luffy)->create();
        $ticket = Ticket::factory()->for($order)->create();

        Livewire::actingAs($luffy)
            ->test(TicketsTable::class, ['order' => $order])
            ->assertTableActionHidden('add-self', $ticket);
    }

    // Header Actions

    // Filters

    #[Test]
    public function can_filter_by_complete_tickets()
    {
        $order = Order::factory()->create();
        $complete = Ticket::factory()->for($order)->completed()->create();
        $invited = Ticket::factory()->for($order)->invited()->create();
        $unassigned = Ticket::factory()->for($order)->create();

        Livewire::test(TicketsTable::class, ['order' => $order])
            ->assertCanSeeTableRecords([$complete, $invited, $unassigned])
            ->filterTable('status', Ticket::COMPLETE)
            ->assertCanSeeTableRecords([$complete])
            ->assertCanNotSeeTableRecords([$invited, $unassigned]);
    }

    #[Test]
    public function can_filter_by_invited_tickets()
    {
        $order = Order::factory()->create();
        $complete = Ticket::factory()->for($order)->completed()->create();
        $invited = Ticket::factory()->for($order)->invited()->create();
        $unassigned = Ticket::factory()->for($order)->create();

        Livewire::test(TicketsTable::class, ['order' => $order])
            ->assertCanSeeTableRecords([$complete, $invited, $unassigned])
            ->filterTable('status', Ticket::INVITED)
            ->assertCanSeeTableRecords([$invited])
            ->assertCanNotSeeTableRecords([$complete, $unassigned]);
    }

    #[Test]
    public function can_filter_by_unassigned_tickets()
    {
        $order = Order::factory()->create();
        $complete = Ticket::factory()->for($order)->completed()->create();
        $invited = Ticket::factory()->for($order)->invited()->create();
        $unassigned = Ticket::factory()->for($order)->create();

        Livewire::test(TicketsTable::class, ['order' => $order])
            ->assertCanSeeTableRecords([$complete, $invited, $unassigned])
            ->filterTable('status', Ticket::UNASSIGNED)
            ->assertCanSeeTableRecords([$unassigned])
            ->assertCanNotSeeTableRecords([$complete, $invited]);
    }

    // @todo searching/sorting
}
