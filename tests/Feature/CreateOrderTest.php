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
            'ticket_type' => $ticket_type->id,
            'ticket_quantity' => 2
        ]);

        $response->assertStatus(201);

        $order = $event->orders()->where('user_id', $user->id)->first();
        $this->assertNotNull($order);
        $this->assertEquals(2, $order->tickets->count());
    }

}
