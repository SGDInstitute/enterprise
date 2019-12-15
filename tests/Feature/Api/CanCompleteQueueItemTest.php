<?php

namespace Tests\Feature\Api;

use App\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CanCompleteQueueItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_complete_single_queue_item()
    {
        $queue = factory(Queue::class)->create();

        $response = $this->withoutExceptionHandling()->json('patch', '/api/queue/'.$queue->id.'/complete');

        $response->assertStatus(200);
        $this->assertEquals(1, $queue->fresh()->completed);
    }

    /** @test */
    public function can_complete_many_queue_items()
    {
        $queues = factory(Queue::class)->times(5)->create();

        $response = $this->withoutExceptionHandling()->json('patch', '/api/queue/'.$queues->implode('id', ',').'/complete');

        $response->assertStatus(200);
        $this->assertEquals([1], $queues->fresh()->pluck('completed')->unique()->all());
    }
}
