<?php

namespace Tests\Feature\Livewire\App;

use App\Http\Livewire\App\MessageBoard;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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
}
