<?php

namespace Tests\Feature\Http\Controllers;

use App\Event;
use App\Order;
use App\Receipt;
use App\TicketType;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrdersController
 */
class OrdersControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_order()
    {
        $event = Event::factory()->published()->create([
            'title' => 'Leadership Conference',
            'slug' => 'leadership-conference',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
        ]);
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $user = User::factory()->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
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
    public function cannot_view_another_users_order()
    {
        $event = Event::factory()->published()->create([
            'title' => 'Leadership Conference',
            'slug' => 'leadership-conference',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
        ]);
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $user = User::factory()->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $notAllowedUser = User::factory()->create();

        $response = $this->actingAs($notAllowedUser)->get("/orders/{$order->id}");

        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_view_payment_details()
    {
        $event = Event::factory()->published()->create();
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make());
        $user = User::factory()->create();
        $order = Order::factory()->paid()->create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'confirmation_number' => '1234123412341234',
        ]);
        $order->receipt()->save(Receipt::factory()->make([
            'card_last_four' => '4242',
            'amount' => '5000',
        ]));

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get("/orders/{$order->id}");

        $response->assertSee('1234-1234-1234-1234');
        $response->assertSee('****-****-****-4242');
        $response->assertSee('$50.00');
    }

    /** @test */
    public function user_can_delete_order()
    {
        $event = Event::factory()->published()->create();
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make());
        $user = User::factory()->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->delete("/orders/{$order->id}");

        $response->assertRedirect('/home');
    }

    /** @test */
    public function cannot_delete_another_users_order()
    {
        $event = Event::factory()->published()->create();
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make());
        $user = User::factory()->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $notAllowedUser = User::factory()->create();

        $response = $this->actingAs($notAllowedUser)->delete("/orders/{$order->id}");

        $response->assertStatus(403);
    }

    /** @test */
    public function cannot_delete_paid_order()
    {
        $event = Event::factory()->published()->create();
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make());
        $user = User::factory()->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);
        $order->markAsPaid($this->charge());

        $response = $this->actingAs($user)->delete("/orders/{$order->id}");

        $response->assertStatus(412);
    }
}
