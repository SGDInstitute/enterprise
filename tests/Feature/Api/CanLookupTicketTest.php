<?php

namespace Tests\Feature\Api;

use App\Order;
use App\Ticket;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanLookupTicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_lookup_ticket_by_hash()
    {
        factory(Ticket::class)->create();
        $ticket = factory(Ticket::class)->create();

        $response = $this->withoutExceptionHandling()->json('get', '/api/tickets/' . $ticket->hash);

        $response->assertStatus(200);
        $this->assertEquals($ticket->id, $response->json('id'));
    }

    /** @test */
    public function can_lookup_ticket_by_ticket_id()
    {
        factory(Ticket::class)->create();
        $ticket = factory(Ticket::class)->create();

        $response = $this->withoutExceptionHandling()->json('get', '/api/tickets/' . $ticket->id);

        $response->assertStatus(200);
        $this->assertEquals($ticket->id, $response->json('id'));
    }
}
