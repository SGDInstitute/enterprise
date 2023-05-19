<?php

namespace Tests\Feature\Livewire\App\MessageBoard\Thread;

use App\Http\Livewire\App\MessageBoard\Thread\Show;
use App\Models\Event;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $thread = Thread::factory()->for($user)->for($event)->create([
            'title' => 'Coordinating travel from central IL',
            'content' => 'Looking to coordinate travel for my students (~10) to MBLGTACC this year.',
            'tags' => ['Travel', 'Illinois'],
        ]);
        
        Livewire::actingAs($user)
            ->test(Show::class, ['event' => $event, 'thread' => $thread])
            ->assertStatus(200)
            ->assertSee('Coordinating travel from central IL')
            ->assertSee('Looking to coordinate travel for my students (~10) to MBLGTACC this year.')
            ->assertSee('Travel')
            ->assertSee('Illinois');
    }
}
