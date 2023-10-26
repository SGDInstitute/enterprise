<?php

namespace Tests\Feature\Livewire\App;

use App\Livewire\App\Checkin;
use App\Livewire\App\Dashboard;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CheckinTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('http_happy_path')]
    public function can_view_app_checkin()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->for($user)->create();

        $this->actingAs($user)
            ->get(route('app.checkin', ['ticket' => $ticket]))
            ->assertOk();
    }

    #[Test]
    public function cannot_view_app_checkin_for_ticket_that_is_not_yours()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create();

        $this->actingAs($user)
            ->get(route('app.checkin', ['ticket' => $ticket]))
            ->assertForbidden();
    }

    #[Test]
    public function can_see_if_ticket_is_in_queue()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->for($user)->create();
        $ticket->addToQueue();

        $this->actingAs($user)
            ->get(route('app.checkin', ['ticket' => $ticket]))
            ->assertSee('Please wait for the notification that your badge is ready');
    }

    #[Test]
    public function can_see_if_ticket_has_been_printed()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->for($user)->create();
        $ticket->addToQueue(printed: true);

        $this->actingAs($user)
            ->get(route('app.checkin', ['ticket' => $ticket]))
            ->assertSee('Your badge is ready!!');
    }

    #[Test]
    public function the_component_can_render(): void
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(Checkin::class, ['ticket' => $ticket])
            ->assertOk();
    }

    // if not in queue see form

    // ability to submit checkin form

    // if no ticket for user show need ticket

    // if not authenticated show need to login
}
