<?php

namespace Tests\Feature\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_component_on_page(): void
    {
        $user = User::factory()->create()->assignRole('institute');
        $event = Event::factory()->preset('mblgtacc')->create();

        $this->actingAs($user)
            ->get('/galaxy/events/' . $event->id . '/edit/media')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events.edit.media');
    }
}
