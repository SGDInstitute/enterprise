<?php

namespace Tests\Feature\Livewire\App;

use App\Features\EventMessageBoard;
use App\Http\Livewire\App\MessageBoard;
use App\Models\Event;
use App\Models\Order;
use App\Models\Post;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Pennant\Feature;
use Livewire\Livewire;
use Spatie\Tags\Tag;
use Tests\TestCase;

class MessageBoardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $event = Event::factory()->create();

        Livewire::test(MessageBoard::class, ['event' => $event])
            ->assertStatus(200);
    }

    /** @test */
    public function forbidden_if_not_authenticated()
    {
        $event = Event::factory()->create();

        $this->get(route('message-board', $event))
            ->assertRedirectToRoute('login');
    }

    /** @test */
    public function forbidden_if_not_verified()
    {
        $user = User::factory()->unverified()->create();
        $event = Event::factory()->create();

        $this->actingAs($user)->get(route('message-board', $event))
            ->assertRedirectToRoute('verification.notice');
    }

    /** @test */
    public function bad_request_if_feature_is_not_enabled_for_event()
    {
        $event = Event::factory()->create();
        $attendee = User::factory()->create();
        $order = Order::factory()->for($event)->create();
        Ticket::factory()->for($attendee)->for($order)->for($event)->create();

        $this->actingAs($attendee)
            ->get(route('message-board', $event))
            ->assertBadRequest();

        $event->settings->set('enable_message_board', true);
        $event->save();

        Feature::forget(EventMessageBoard::class);

        $this->actingAs($attendee)
            ->withoutExceptionHandling()
            ->get(route('message-board', $event))
            ->assertSuccessful();
    }

    /** @test */
    public function forbidden_if_user_does_not_have_ticket_for_event()
    {
        Feature::define(EventMessageBoard::class, true);

        $event = Event::factory()->create();
        $user = User::factory()->create();

        $attendee = User::factory()->create();
        $order = Order::factory()->for($event)->create();
        Ticket::factory()->for($attendee)->for($order)->for($event)->create();

        $this->actingAs($user)->get(route('message-board', $event))
            ->assertForbidden();

        $this->actingAs($attendee)->get(route('message-board', $event))
            ->assertSuccessful();
    }

    /** @test */
    public function cannot_view_if_user_has_not_accepted_terms()
    {
    }

    /** @test */
    public function cannot_view_posts_that_have_not_been_approved()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        Post::factory()->for($user)->for($event)->create([
            'title' => 'Hello world',
            'approved_at' => null,
            'approved_by' => null,
        ]);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->assertDontSee('Hello world');
    }

    /** @test */
    public function can_view_posts()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        Post::factory()->for($user)->for($event)->approved()->create(['title' => 'Hello world']);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->assertSee('Hello world');
    }

    /** @test */
    public function can_filter_posts()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        $tag = Tag::create(['name' => 'illinois']);
        Post::factory()->for($user)->for($event)->approved()->create(['title' => 'Hello world']);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->assertSee('Hello world')
            ->set('tagsFilter', [$tag->id])
            ->assertDontSee('Hello world');
    }

    /** @test */
    public function can_search_posts_by_title()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        Post::factory()->for($user)->for($event)->approved()->create(['title' => 'Hello world']);
        Post::factory()->for($user)->for($event)->approved()->create(['title' => 'New Post']);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->set('search', 'New')
            ->assertDontSee('Hello world')
            ->assertSee('New Post')
            ->set('search', 'Hello')
            ->assertSee('Hello world')
            ->assertDontSee('New Post');
    }

    /** @test */
    public function can_search_posts_by_content()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        Post::factory()->for($user)->for($event)->approved()->create(['title' => 'Hello world', 'content' => 'Foo Bar']);
        Post::factory()->for($user)->for($event)->approved()->create(['title' => 'New Post', 'content' => 'Baz']);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->set('search', 'Foo')
            ->assertSee('Hello world')
            ->assertDontSee('New Post')
            ->set('search', 'Baz')
            ->assertDontSee('Hello world')
            ->assertSee('New Post');
    }

    /** @test */
    public function filtering_posts_does_not_show_unapproved()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        $tag = Tag::create(['name' => 'illinois']);
        $post = Post::factory()->for($user)->for($event)->create(['title' => 'Hello world']);
        $post->attachTag($tag);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->assertDontSee('Hello world')
            ->set('tagsFilter', [$tag->id])
            ->assertDontSee('Hello world');
    }

    /** @test */
    public function searching_posts_by_title_does_not_show_unapproved()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        Post::factory()->for($user)->for($event)->create(['title' => 'New Post']);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->set('search', 'New')
            ->assertDontSee('New Post')
            ->set('search', 'Hello')
            ->assertDontSee('New Post');
    }

    /** @test */
    public function searching_posts_by_content_does_not_show_unapproved()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->for($event)->create([
            'title' => 'Hello world', 
            'content' => 'Foo Bar',
            'approved_at' => null,
            'approved_by' => null,
        ]);


        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->assertDontSee('Hello world')
            ->set('search', 'Foo')
            ->assertDontSee('Hello world');
    }
}
