<?php

namespace Tests\Feature\Livewire\App\MessageBoard\Thread;

use App\Http\Livewire\App\MessageBoard\Thread\Create;
use App\Models\Event;
use App\Models\Thread;
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
    public function can_create_thread()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $tag = Tag::findOrCreate('Illinois', 'threads');

        Livewire::actingAs($user)
            ->test(Create::class, ['event' => $event])
            ->fillForm([
                'title' => 'Heading to KY from IL',
                'content' => 'I am heading to Lexington from Chicago, let me know if you want to join.',
                'tags' => ['Illinois'],
            ])
            ->call('submit');

        $this->assertCount(1, $user->threads);
        $thread = $user->threads->first();
        $this->assertEquals('Heading to KY from IL', $thread->title);
        $this->assertEquals('heading-to-ky-from-il', $thread->slug);
        $this->assertEquals($tag->id, $thread->tags->first()->id);
    }
}
