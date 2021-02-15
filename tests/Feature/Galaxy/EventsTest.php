<?php

namespace Tests\Feature\Galaxy;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_events_component_on_events_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/galaxy/events')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events');
    }
}
