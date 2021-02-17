<?php

namespace Tests\Feature\Galaxy\Events\Show;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_component_on_page()
    {
        $user = User::factory()->create();
        $event = Event::factory()->preset('mblgtacc')->create();

        $this->actingAs($user)
            ->get('/galaxy/events/' . $event->id . '/dashboard')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events.show.dashboard');
    }
}
