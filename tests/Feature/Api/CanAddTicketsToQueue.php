<?php

namespace Tests\Feature\Api;

use App\Queue;
use App\Ticket;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanAddTicketsToQueue extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_add_tickets_to_queue()
    {
        $tickets = factory(Ticket::class)->times(5)->create();
        $response = $this->withoutExceptionHandling()->json('post', "/api/queue/{$tickets->implode('id', ',')}");

        $response->assertStatus(201);
        $this->assertCount(5, Queue::all());
    }
}
