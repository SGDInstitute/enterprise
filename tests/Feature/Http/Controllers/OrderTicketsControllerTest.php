<?php

namespace Tests\Feature\Http\Controllers;

use App\Event;
use App\Mail\InviteUserEmail;
use App\Order;
use App\Ticket;
use App\TicketType;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrderTicketsController
 */
class OrderTicketsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_invite_multiple_users()
    {
        Mail::fake();

        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = factory(Order::class)->create(['event_id' => $event->id, 'user_id' => $user->id]);
        $ticket1 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);
        $ticket2 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);

        $response = $this->withoutExceptionHandling()->actingAs($user)
            ->patch("/orders/{$order->id}/tickets", [
                'emails' => [$ticket1->hash => 'hpotter@hogwarts.edu', $ticket2->hash => 'hgranger@hogwarts.edu'],
                'message' => "You're invited to this awesome event!",
            ]);

        $response->assertStatus(200);

        $this->assertEquals(2, $order->tickets()->filled()->count());
        $this->assertEquals($ticket1->fresh()->user_id, User::findByEmail('hpotter@hogwarts.edu')->id);
        $this->assertEquals($ticket2->fresh()->user_id, User::findByEmail('hgranger@hogwarts.edu')->id);

        Mail::assertSent(InviteUserEmail::class, function ($mail) {
            return $mail->hasTo('hpotter@hogwarts.edu')
                && $mail->note === 'You\'re invited to this awesome event!';
        });

        Mail::assertSent(InviteUserEmail::class, function ($mail) {
            return $mail->hasTo('hgranger@hogwarts.edu')
                && $mail->note === 'You\'re invited to this awesome event!';
        });
    }

    /** @test */
    public function email_is_required()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = factory(Order::class)->create(['event_id' => $event->id, 'user_id' => $user->id]);
        $ticket1 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);
        $ticket2 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);
        $ticket3 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);
        $ticket4 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);

        $response = $this->actingAs($user)
            ->json('patch', "/orders/{$order->id}/tickets", [
                'emails' => [
                    $ticket1->hash => '',
                    $ticket2->hash => '',
                    $ticket3->hash => '',
                    $ticket4->hash => '',
                ],
                'message' => "You're invited to this awesome event!",
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors();
    }

    /** @test */
    public function at_least_one_email_is_required()
    {
        Mail::fake();

        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = factory(Order::class)->create(['event_id' => $event->id, 'user_id' => $user->id]);
        $ticket1 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);
        $ticket2 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);
        $ticket3 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);
        $ticket4 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);

        $response = $this->actingAs($user)
            ->json('patch', "/orders/{$order->id}/tickets", [
                'emails' => [
                    $ticket1->hash => 'hpotter@hogwarts.edu',
                    $ticket2->hash => '',
                    $ticket3->hash => '',
                    $ticket4->hash => '',
                ],
                'message' => "You're invited to this awesome event!",
            ]);

        $response->assertStatus(200);

        $this->assertEquals(1, $order->tickets()->filled()->count());
        $this->assertEquals($ticket1->fresh()->user_id, User::findByEmail('hpotter@hogwarts.edu')->id);

        Mail::assertSent(InviteUserEmail::class, function ($mail) {
            return $mail->hasTo('hpotter@hogwarts.edu');
        });
    }

    /** @test */
    public function email_must_be_email()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = factory(Order::class)->create(['event_id' => $event->id, 'user_id' => $user->id]);
        $ticket = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);

        $response = $this->actingAs($user)
            ->json('patch', "/orders/{$order->id}/tickets", [
                'emails' => [
                    $ticket->hash => 'asdfasdf',
                ],
                'message' => "You're invited to this awesome event!",
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors();
    }
}