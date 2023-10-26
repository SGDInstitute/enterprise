<?php

namespace Tests\Unit\Models;

use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_see_if_user_has_comped_ticket_for_event()
    {
        $event = Event::factory()->has(TicketType::factory()->withPrice()->count(2))->create();
        [$userA, $userB] = User::factory()->count(2)->create();
        Order::factory()
            ->for($event)
            ->for($userA)
            ->has(Ticket::factory()->for($userB))
            ->paid('comped')
            ->create();

        $this->assertFalse($userA->hasCompedTicketFor($event));
        $this->assertTrue($userB->hasCompedTicketFor($event));
    }

    #[Test]
    public function can_see_if_user_is_registered_for_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $order = Order::factory()->for($event)->paid()->create();
        Ticket::factory()->for($event)->for($order)->for($user)->create();

        $this->assertTrue($user->isRegisteredFor($event));

        $user = User::factory()->create();
        $event = Event::factory()->create();
        $order = Order::factory()->for($event)->create();
        Ticket::factory()->for($event)->for($order)->for($user)->create();

        $this->assertFalse($user->isRegisteredFor($event));
    }

    #[Test]
    public function can_get_ticket_for_user()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        Ticket::factory()->for($event)->for($user)->create();

        $order = Order::factory()->for($event)->paid()->create();
        $paidTicket = Ticket::factory()->for($event)->for($order)->for($user)->create();

        $this->assertEquals($paidTicket->id, $user->ticketForEvent($event)->id);

        $user = User::factory()->create();
        $event = Event::factory()->create();
        $unpaidTicket = Ticket::factory()->for($event)->for($user)->create();

        $this->assertEquals($unpaidTicket->id, $user->ticketForEvent($event)->id);
    }
}
