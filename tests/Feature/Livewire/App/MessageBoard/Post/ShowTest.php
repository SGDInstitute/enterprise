<?php

namespace Tests\Feature\Livewire\App\MessageBoard\Post;

use App\Http\Livewire\App\MessageBoard\Post\Show;
use App\Models\Event;
use App\Models\Post;
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

        $post = Post::factory()->for($user)->for($event)->create([
            'title' => 'Coordinating travel from central IL',
            'content' => 'Looking to coordinate travel for my students (~10) to MBLGTACC this year.',
            'tags' => ['Travel', 'Illinois'],
        ]);

        Livewire::actingAs($user)
            ->test(Show::class, ['event' => $event, 'post' => $post])
            ->assertStatus(200)
            ->assertSee('Coordinating travel from central IL')
            ->assertSee('Looking to coordinate travel for my students (~10) to MBLGTACC this year.')
            ->assertSee('Travel')
            ->assertSee('Illinois');
    }

    /** @test */
    public function if_post_has_not_been_approved_notice_is_visable()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $post = Post::factory()->for($user)->for($event)->create([
            'approved_at' => null,
            'approved_by' => null,
        ]);

        Livewire::actingAs($user)
            ->test(Show::class, ['event' => $event, 'post' => $post])
            ->assertStatus(200)
            ->assertSee('post-not-approved-notice');
    }
}
