<?php

namespace Tests\Feature\Api;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CanLookupTicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_lookup_ticket_by_hash()
    {
        Ticket::factory()->create();
        $ticket = Ticket::factory()->create();

        $response = $this->withoutExceptionHandling()->json('get', '/api/tickets/'.$ticket->hash);

        $response->assertStatus(200);
        $this->assertEquals($ticket->id, $response->json('id'));
    }

    /** @test */
    public function can_lookup_ticket_by_ticket_id()
    {
        Ticket::factory()->create();
        $ticket = Ticket::factory()->create();

        $response = $this->withoutExceptionHandling()->json('get', '/api/tickets/'.$ticket->id);

        $response->assertStatus(200);
        $this->assertEquals($ticket->id, $response->json('id'));
    }
}
