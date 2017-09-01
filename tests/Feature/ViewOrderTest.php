<?php

namespace Tests\Feature;

use App\Event;
use App\Order;
use App\TicketType;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_view_order()
    {
        $event = factory(Event::class)->states('published')->create([
            'title' => 'Leadership Conference',
            'slug' => 'leadership-conference',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
        ]);
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $user = factory(User::class)->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get("/orders/{$order->id}");

        $response->assertStatus(200);
        $response->assertSee('Leadership Conference');
        $response->assertSee('University of Nebraska');
        $response->assertSee('Omaha, Nebraska');
        $response->assertSee('Fri, Feb 16 - Sun, Feb 18');
        $response->assertSee('$100.00');
        $response->assertSee('0 of 2');
    }

    /** @test */
    function cannot_view_another_users_order()
    {
        $event = factory(Event::class)->states('published')->create([
            'title' => 'Leadership Conference',
            'slug' => 'leadership-conference',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
        ]);
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $user = factory(User::class)->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $notAllowedUser = factory(User::class)->create();

        $response = $this->actingAs($notAllowedUser)->get("/orders/{$order->id}");

        $response->assertStatus(403);
    }

    /** @test */
    function user_can_view_payment_details()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create();
        $order = factory(Order::class)->states('paid')->create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'confirmation_number' => '1234123412341234',
            'card_last_four' => '4242',
            'amount' => '5000'
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get("/orders/{$order->id}");

        $response->assertSee('1234-1234-1234-1234');
        $response->assertSee('****-****-****-4242');
        $response->assertSee('$50.00');
    }
}
