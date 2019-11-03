<?php

namespace Tests\Feature;

use App\Ticket;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddExistingUserToTicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function add_user_to_ticket()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => null,
        ]);
        $user = factory(User::class)->create(['email' => 'jo@example.com']);

        $response = $this->withoutExceptionHandling()->actingAs($user)
            ->patch("/tickets/{$ticket->hash}", [
                'user_id' => $user->id,
            ]);

        $response->assertStatus(200);

        $this->assertEquals($ticket->fresh()->user_id, $user->id);
    }
}
