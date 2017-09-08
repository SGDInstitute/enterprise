<?php

namespace Tests\Feature;

use App\Event;
use App\TicketType;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddUsersToTicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_view_edit_page()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $response = $this->withoutExceptionHandling()->actingAs($user)
            ->get("/orders/{$order->id}/tickets");

        $response->assertStatus(200)
            ->assertViewHas('tickets');
    }
}
