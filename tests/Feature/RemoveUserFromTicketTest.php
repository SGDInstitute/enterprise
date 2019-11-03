<?php

namespace Tests\Feature;

use App\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveUserFromTicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function remove_user_from_ticket()
    {
        $ticket = factory(Ticket::class)->create();

        $response = $this->withoutExceptionHandling()->actingAs($ticket->order->user)
            ->delete("/tickets/{$ticket->hash}/users");

        $response->assertStatus(200);

        $this->assertNull($ticket->fresh()->user_id);
    }
}
