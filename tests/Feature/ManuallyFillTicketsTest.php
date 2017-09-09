<?php

namespace Tests\Feature;

use App\Event;
use App\Order;
use App\Ticket;
use App\TicketType;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManuallyFillTicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function manually_add_information()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => null
        ]);
        $user = factory(User::class)->create(['email' => 'jo@example.com']);

        $response = $this->withoutExceptionHandling()->actingAs($user)
            ->patch("/tickets/{$ticket->hash}", [
                'name' => 'Harry Potter',
                'email' => 'hpotter@hogwarts.edu',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'tshirt' => 'L',
                'accommodation' => 'My scar hurts sometimes'
            ]);

        $response->assertStatus(200);

        $ticket->refresh();
        $this->assertNotNull($ticket->user_id);
        $this->assertEquals('Harry Potter', $ticket->user->name);
        $this->assertEquals('hpotter@hogwarts.edu', $ticket->user->email);
        $this->assertEquals('he, him, his', $ticket->user->profile->pronouns);
        $this->assertEquals('Straight', $ticket->user->profile->sexuality);
        $this->assertEquals('Male', $ticket->user->profile->gender);
        $this->assertEquals('White', $ticket->user->profile->race);
        $this->assertEquals('Hogwarts', $ticket->user->profile->college);
        $this->assertEquals('L', $ticket->user->profile->tshirt);
        $this->assertEquals('My scar hurts sometimes', $ticket->user->profile->accommodation);
    }

    /** @test */
    function email_must_be_email()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = factory(Order::class)->create(['event_id' => $event->id, 'user_id' => $user->id]);
        $ticket = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id
        ]);

        $response = $this->actingAs($user)
            ->json("patch", "/orders/{$order->id}/tickets", [
                'emails' => [
                    $ticket->hash => 'asdfasdf',
                ],
                'message' => "You're invited to this awesome event!"
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors();
    }
}