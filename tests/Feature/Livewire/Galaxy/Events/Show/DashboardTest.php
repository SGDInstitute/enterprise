<?php

namespace Tests\Feature\Livewire\Galaxy\Events\Show;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_component_on_page()
    {
        $user = User::factory()->create()->assignRole('institute');
        $event = Event::factory()->preset('mblgtacc')->create();

        $this->actingAs($user)
            ->get('/galaxy/events/'.$event->id.'/dashboard')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events.show.dashboard');
    }
}
