<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TicketsUsersController
 */
class TicketsUsersControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function remove_user_from_ticket()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->withoutExceptionHandling()->actingAs($ticket->order->user)
            ->delete("/tickets/{$ticket->hash}/users");

        $response->assertStatus(200);

        $this->assertNull($ticket->fresh()->user_id);
    }
}
