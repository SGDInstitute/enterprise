<?php

namespace Tests\Feature;

use App\Event;
use App\TicketType;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateOrderTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    function user_can_create_order()
    {
        $user = factory(User::class)->create([
            'email' => 'john@example.com'
        ]);
        $event = factory(Event::class)->create([
            'title' => 'MBLGTACC',
            'slug' => 'mblgtacc'
        ]);
        $ticket_type = factory(TicketType::class)->make([
            'name' => 'Regular Ticket',
            'cost' => 5000
        ]);
        $event->ticket_types()->save($ticket_type);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->json('POST', "/events/{$event->slug}/orders", [
                'tickets' => [
                    ['ticket_type_id' => $ticket_type->id, 'quantity' => 2,]
                ],
        ]);

        $response->assertStatus(201);

        $order = $event->orders()->where('user_id', $user->id)->first();
        $this->assertNotNull($order);
        $this->assertEquals(2, $order->tickets->count());
    }

    /** @test */
    function user_can_create_order_with_multiple_ticket_types()
    {
        $user = factory(User::class)->create([
            'email' => 'john@example.com'
        ]);
        $event = factory(Event::class)->create([
            'title' => 'MBLGTACC',
            'slug' => 'mblgtacc'
        ]);
        $regular = factory(TicketType::class)->make([
            'name' => 'Regular Ticket',
            'cost' => 5000
        ]);
        $pro = factory(TicketType::class)->make([
            'name' => 'Pro Ticket',
            'cost' => 7500
        ]);
        $event->ticket_types()->save($regular);
        $event->ticket_types()->save($pro);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->json('POST', "/events/{$event->slug}/orders", [
                'tickets' => [
                    ['ticket_type_id' => $regular->id, 'quantity' => 2,],
                    ['ticket_type_id' => $pro->id, 'quantity' => 4,],
                ],
            ]);

        $response->assertStatus(201);

        $order = $event->orders()->where('user_id', $user->id)->first();
        $this->assertNotNull($order);
        $this->assertEquals(6, $order->tickets->count());
        $this->assertEquals(2, $order->tickets->where('ticket_type_id', $regular->id)->count());
        $this->assertEquals(4, $order->tickets->where('ticket_type_id', $pro->id)->count());
    }

    /** @test */
    function cannot_create_order_for_unpublished_event()
    {
        $user = factory(User::class)->create();
        $event = factory(Event::class)->states('unpublished')->create();
        $ticket_type = factory(TicketType::class)->make();
        $event->ticket_types()->save($ticket_type);

        $response = $this->actingAs($user)
            ->json('POST', "/events/{$event->slug}/orders", [
                'tickets' => [
                    ['ticket_type_id' => $ticket_type->id, 'quantity' => 2,]
                ],
            ]);

        $response->assertStatus(404);
        $this->assertEquals(0, $event->orders()->count());
    }

}
