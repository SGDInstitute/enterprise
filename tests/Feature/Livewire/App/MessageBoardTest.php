<?php

namespace Tests\Feature\Livewire\App;

use App\Http\Livewire\App\MessageBoard;
use App\Models\Event;
use App\Models\Order;
use App\Models\Thread;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function forbidden_if_user_does_not_have_ticket_for_event()
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

    /** @test */
    public function cannot_view_if_user_has_not_accepted_terms()
    {
    }

    /** @test */
    public function can_view_threads()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        Thread::factory()->for($user)->for($event)->create(['title' => 'Hello world']);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->assertSee('Hello world');
    }

    /** @test */
    public function can_filter_threads()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        $tag = Tag::create(['name' => 'illinois']);
        Thread::factory()->for($user)->for($event)->create(['title' => 'Hello world']);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->set('tagsFilter', [$tag->id])
            ->assertDontSee('Hello world');
    }

    /** @test */
    public function can_search_threads_by_title()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        Thread::factory()->for($user)->for($event)->create(['title' => 'Hello world']);
        Thread::factory()->for($user)->for($event)->create(['title' => 'New Post']);

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
    public function can_search_threads_by_content()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        Thread::factory()->for($user)->for($event)->create(['title' => 'Hello world', 'content' => 'Foo Bar']);
        Thread::factory()->for($user)->for($event)->create(['title' => 'New Post', 'content' => 'Baz']);

        Livewire::actingAs($user)
            ->test(MessageBoard::class, ['event' => $event])
            ->set('search', 'Foo')
            ->assertSee('Hello world')
            ->assertDontSee('New Post')
            ->set('search', 'Baz')
            ->assertDontSee('Hello world')
            ->assertSee('New Post');
    }
}
