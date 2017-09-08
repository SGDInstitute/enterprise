<?php

namespace Tests\Feature;

use App\Event;
use App\Mail\InviteUserEmail;
use App\Order;
use App\Ticket;
use App\TicketType;
use App\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddUsersToTicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_invite_multiple_users()
    {
        Mail::fake();

        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = factory(Order::class)->create(['event_id' => $event->id, 'user_id' => $user->id]);
        $ticket1 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'ticket_type_id' => $ticketType->id
        ]);
        $ticket2 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'ticket_type_id' => $ticketType->id
        ]);

        $response = $this->withoutExceptionHandling()->actingAs($user)
            ->patch("/orders/{$order->id}/tickets", [
                'emails' => [$ticket1->hash => 'hpotter@hogwarts.edu', $ticket2->hash => 'hgranger@hogwarts.edu'],
                'message' => "You're invited to this awesome event!"
            ]);

        $response->assertStatus(200);

        $this->assertEquals(2, $order->tickets()->filled()->count());

        Mail::assertSent(InviteUserEmail::class, function($mail) {
            return $mail->hasTo('hpotter@hogwarts.edu');
        });

        Mail::assertSent(InviteUserEmail::class, function($mail) {
            return $mail->hasTo('hgranger@hogwarts.edu');
        });
    }
}
