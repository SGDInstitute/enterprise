<?php

namespace Tests\Feature\Livewire\App;

use App\Livewire\App\Checkin;
use App\Models\Event;
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
    public function see_form_if_not_in_queue()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->for($user)->create();

        $this->actingAs($user)
            ->get(route('app.checkin', ['ticket' => $ticket]))
            ->assertSee('Are your name and pronouns correct?');
    }

    #[Test]
    public function see_need_ticket_if_user_has_none()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('app.checkin'))
            ->assertSee('you can purchase one.');
    }

    #[Test]
    public function show_login_reminder_if_not_authenticated()
    {
        $this->get(route('app.checkin'))
            ->assertSee('Please create an account or log in before checking in.');
    }

    #[Test]
    public function show_reminder_to_pay_if_ticket_is_unpaid()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $ticket = Ticket::factory()->for($user)->for($order)->create();

        $this->actingAs($user)
            ->get(route('app.checkin', ['ticket' => $ticket]))
            ->assertSee('This ticket has not been paid for yet.')
            ->assertDontSee('Pay Now');

        $user = User::factory()->create();
        $order = Order::factory()->paid()->create();
        $ticket = Ticket::factory()->for($user)->for($order)->create();

        $this->actingAs($user)
            ->get(route('app.checkin', ['ticket' => $ticket]))
            ->assertDontSee('This ticket has not been paid for yet.')
            ->assertDontSee('Pay Now');
    }

    #[Test]
    public function order_owner_sees_redirect_to_payment_page()
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->create();
        $ticket = Ticket::factory()->for($user)->for($order)->create();

        $this->actingAs($user)
            ->get(route('app.checkin', ['ticket' => $ticket]))
            ->assertSee('This ticket has not been paid for yet.')
            ->assertSee('Pay Now');
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

    #[Test]
    public function can_add_ticket_to_queue()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(Checkin::class, ['ticket' => $ticket])
            ->assertSet('user.email', $user->email)
            ->assertSet('user.name', $user->name)
            ->assertSet('user.pronouns', $user->pronouns)
            ->set('user.notifications_via', ['mail'])
            ->call('add')
            ->assertHasNoErrors()
            ->assertDispatched('notify');

        $this->assertTrue($ticket->fresh()->isQueued());
    }

    #[Test]
    public function phone_is_required_if_they_want_texts()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(Checkin::class, ['ticket' => $ticket])
            ->assertSet('user.email', $user->email)
            ->assertSet('user.name', $user->name)
            ->assertSet('user.pronouns', $user->pronouns)
            ->set('user.notifications_via', ['vonage'])
            ->call('add')
            ->assertHasErrors('user.phone');

        $this->assertFalse($ticket->fresh()->isQueued());
    }

    #[Test]
    public function if_no_ticket_passed_in_select_ticket_from_upcoming_event()
    {
        $mbl2022 = Event::factory()->create(['name' => '2022', 'start' => now()->subWeek(), 'end' => now()->subWeek()]);
        $mbl2023 = Event::factory()->create(['name' => '2023', 'start' => now()->addWeek(), 'end' => now()->addWeek()]);

        $user = User::factory()->create();
        Ticket::factory()->for($mbl2022)->for($user)->create();
        $mbl2023Ticket = Ticket::factory()->for($mbl2023)->for($user)->create();

        Livewire::actingAs($user)
            ->test(Checkin::class)
            ->assertSet('event.id', $mbl2023->id)
            ->assertSet('ticket.id', $mbl2023Ticket->id);
    }
}
