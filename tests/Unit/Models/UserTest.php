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
}
