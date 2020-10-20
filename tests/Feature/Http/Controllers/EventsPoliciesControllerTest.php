<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventsPoliciesController
 */
class EventsPoliciesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_event_refund_policy()
    {
        $event = Event::factory()->published()->create([
            'title' => 'MBLGTACC',
            'slug' => 'mblgtacc',
            'refund_policy' => '<p>Refund Policy</p>',
        ]);

        $response = $this->withoutExceptionHandling()->get('/events/mblgtacc/policies/refund');

        $response->assertStatus(200);
        $response->assertSee('MBLGTACC');
        $response->assertSee('Refund Policy');
    }
}
