<?php

namespace Tests\Feature\Livewire\App;

use App\Livewire\App\MessageBoard;
use App\Models\Event;
use App\Models\Order;
use App\Models\Post;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Tags\Tag;
use Tests\TestCase;

final class MessageBoardTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('http_happy_path')]
    public function can_view_message_board(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        Ticket::factory()->for($user)->for($event)->create();

        $this->actingAs($user)
            ->get(route('message-board', $event))
            ->assertSuccessful();
    }

    #[Test]
    public function forbidden_if_not_authenticated(): void
    {
        $event = Event::factory()->create();

        $this->get(route('message-board', $event))
            ->assertRedirectToRoute('login');
    }

    #[Test]
    public function forbidden_if_not_verified(): void
    {
        $user = User::factory()->unverified()->create();
        $event = Event::factory()->create();

        $this->actingAs($user)->get(route('message-board', $event))
            ->assertRedirectToRoute('verification.notice');
    }

    #[Test]
    public function forbidden_if_user_does_not_have_ticket_for_event(): void
    {
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

    #[Test]
    public function cannot_view_if_user_has_not_accepted_terms(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        Ticket::factory()->for($user)->for($event)->create();
        Post::factory()->approved()->create(['title' => 'Hello world']);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->assertDontSee('Hello world')
            ->assertSee('Welcome! The MBLGTACC Attendee Message Board')
            ->callAction('accept');

        $this->assertNotNull($user->terms[$event->slug]);
    }

    #[Test]
    public function cannot_view_posts_that_have_not_been_approved(): void
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

    #[Test]
    public function can_view_posts(): void
    {
        $event = Event::factory()->create();
        $user = User::factory()->create(['terms' => [$event->slug => now()]]);
        Post::factory()->for($user)->for($event)->approved()->create(['title' => 'Hello world']);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->assertSee('Hello world');
    }

    #[Test]
    public function can_filter_posts(): void
    {
        $event = Event::factory()->create();
        $user = User::factory()->create(['terms' => [$event->slug => now()]]);
        $tag = Tag::create(['name' => 'illinois']);
        Post::factory()->for($user)->for($event)->approved()->create(['title' => 'Hello world']);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->assertSee('Hello world')
            ->set('tagsFilter', [$tag->id])
            ->assertDontSee('Hello world');
    }

    #[Test]
    public function can_search_posts_by_title(): void
    {
        $event = Event::factory()->create();
        $user = User::factory()->create(['terms' => [$event->slug => now()]]);
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

    #[Test]
    public function can_search_posts_by_content(): void
    {
        $event = Event::factory()->create();
        $user = User::factory()->create(['terms' => [$event->slug => now()]]);
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

    #[Test]
    public function filtering_posts_does_not_show_unapproved(): void
    {
        $event = Event::factory()->create();
        $user = User::factory()->create(['terms' => [$event->slug => now()]]);
        $tag = Tag::create(['name' => 'illinois']);
        $post = Post::factory()->for($user)->for($event)->create(['title' => 'Hello world']);
        $post->attachTag($tag);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->assertDontSee('Hello world')
            ->set('tagsFilter', [$tag->id])
            ->assertDontSee('Hello world');
    }

    #[Test]
    public function searching_posts_by_title_does_not_show_unapproved(): void
    {
        $event = Event::factory()->create();
        $user = User::factory()->create(['terms' => [$event->slug => now()]]);
        Post::factory()->for($user)->for($event)->create(['title' => 'New Post']);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->set('search', 'New')
            ->assertDontSee('New Post')
            ->set('search', 'Hello')
            ->assertDontSee('New Post');
    }

    #[Test]
    public function searching_posts_by_content_does_not_show_unapproved(): void
    {
        $event = Event::factory()->create();
        $user = User::factory()->create(['terms' => [$event->slug => now()]]);
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
