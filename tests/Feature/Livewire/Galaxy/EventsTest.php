<?php

namespace Tests\Feature\Livewire\Galaxy;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_events_component_on_events_page(): void
    {
        $user = User::factory()->create()->assignRole('institute');

        $this->actingAs($user)
            ->get('/galaxy/events')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events');
    }
}
