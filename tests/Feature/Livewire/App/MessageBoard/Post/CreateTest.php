<?php

namespace Tests\Feature\Livewire\App\MessageBoard\Post;

use App\Http\Livewire\App\MessageBoard\Post\Create;
use App\Models\Event;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Tags\Tag;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function form_can_render()
    {
        $event = Event::factory()->create();

        Livewire::test(Create::class, ['event' => $event])
            ->assertFormExists()
            ->assertFormFieldExists('title')
            ->assertFormFieldExists('content')
            ->assertFormFieldExists('tags')
            ->assertStatus(200);
    }

    /** @test */
    public function can_create_post()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $tag = Tag::findOrCreate('Illinois', 'posts');

        Livewire::actingAs($user)
            ->test(Create::class, ['event' => $event])
            ->fillForm([
                'title' => 'Heading to KY from IL',
                'content' => 'I am heading to Lexington from Chicago, let me know if you want to join.',
                'tags' => ['Illinois'],
            ])
            ->call('submit');

        $this->assertCount(1, $user->posts);
        $post = $user->posts->first();
        $this->assertEquals('Heading to KY from IL', $post->title);
        $this->assertEquals($tag->id, $post->tags->first()->id);
    }

    /** @test */
    public function saving_post_redirects_to_show_page()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        Livewire::actingAs($user)
            ->test(Create::class, ['event' => $event])
            ->fillForm([
                'title' => 'Heading from KY to IL',
                'content' => 'I am heading to Lexington from Chicago, let me know if you want to join.',
                'tags' => ['Illinois'],
            ])
            ->call('submit')
            ->assertRedirect(route('posts.show', [$event, Post::where('title', 'Heading from KY to IL')->first()]));
    }
}
