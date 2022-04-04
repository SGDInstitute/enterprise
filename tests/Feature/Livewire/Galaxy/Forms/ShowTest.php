<?php

namespace Tests\Feature\Livewire\Galaxy\Forms;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_component_on_page()
    {
        $user = User::factory()->create()->assignRole('institute');
        $event = Event::factory()->preset('mblgtacc')->create();

        $this->actingAs($user)
            ->get('/galaxy/events/' . $event->id . '/edit/workshops')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events.edit.workshop-form');
    }
}
