<?php

namespace Tests\Feature\Galaxy\Events\Edit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddOnsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_event_details_component_on_event_details_page()
    {
        $user = User::factory()->create();
        $event = Event::factory()->preset('mblgtacc')->create();

        $this->actingAs($user)
            ->get('/galaxy/events/' . $event->id . '/addons')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events.addons');
    }
}
