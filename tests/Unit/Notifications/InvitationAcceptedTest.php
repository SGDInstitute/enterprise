<?php

namespace Tests\Unit\Notifications;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Invitation;
use App\Models\Order;
use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\InvitationAccepted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationAcceptedTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function response_notification_has_url()
    {
        $response = Response::factory()->create();
        $user = User::factory()->create();

        $notification = (new InvitationAccepted($response, $user))->toMail($user);

        $this->assertEquals(route('app.forms.show', ['form' => $response->form, 'edit' => $response]), $notification->actionUrl);
    }

    #[Test]
    public function ticket_notification_has_url()
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();
        $ticket = Ticket::factory()->for($order)->for($user)->create();

        $notification = (new InvitationAccepted($ticket, $user))->toMail($user);

        $this->assertEquals(route('app.orders.show', $order), $notification->actionUrl);
    }

    #[Test]
    public function ticket_notification_pending_invitation_many()
    {
        $order = Order::factory()->hasTickets(2)->create();
        $user = User::factory()->create();
        $order->tickets->each(fn ($ticket) => Invitation::factory()->for($ticket, 'inviteable')->create());

        $notification = (new InvitationAccepted($order->tickets->first(), $user))->toMail($user)->render();

        $this->assertStringContainsString('There are 2 pending invitations.', $notification);
    }

    #[Test]
    public function ticket_notification_pending_invitation_single()
    {
        $order = Order::factory()->hasTickets(1)->create();
        $user = User::factory()->create();
        $order->tickets->each(fn ($ticket) => Invitation::factory()->for($ticket, 'inviteable')->create());

        $notification = (new InvitationAccepted($order->tickets->first(), $user))->toMail($user)->render();

        $this->assertStringContainsString('There is 1 pending invitation.', $notification);
    }

    #[Test]
    public function ticket_notification_to_assign_many()
    {
        $order = Order::factory()->hasTickets(2)->create();
        $user = User::factory()->create();

        $notification = (new InvitationAccepted($order->tickets->first(), $user))->toMail($user)->render();

        $this->assertStringContainsString('There are 2 tickets that have not been assigned.', $notification);
    }

    #[Test]
    public function ticket_notification_to_assign_single()
    {
        $order = Order::factory()->hasTickets(1)->create();
        $user = User::factory()->create();

        $notification = (new InvitationAccepted($order->tickets->first(), $user))->toMail($user)->render();

        $this->assertStringContainsString('There is 1 ticket that has not been assigned.', $notification);
    }

    #[Test]
    public function ticket_payment_reminder_if_reservation()
    {
        $order = Order::factory()->hasTickets(1)->create();
        $user = User::factory()->create();

        $notification = (new InvitationAccepted($order->tickets->first(), $user))->toMail($user)->render();

        $this->assertStringContainsString('Please remember, your payment is due by', $notification);
    }
}
