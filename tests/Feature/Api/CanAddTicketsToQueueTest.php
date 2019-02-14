<?php

namespace Tests\Feature\Api;

use App\Queue;
use App\Ticket;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanAddTicketsToQueueTest extends TestCase
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

    /** @test */
    public function cannot_add_double_tickets_to_queue()
    {
        $tickets = factory(Ticket::class)->times(5)->create();
        $responseA = $this->withoutExceptionHandling()->json('post', "/api/queue/{$tickets->implode('id', ',')}");
        $responseB = $this->withoutExceptionHandling()->json('post', "/api/queue/{$tickets->implode('id', ',')}");

        $this->assertCount(5, Queue::all());
    }
}
