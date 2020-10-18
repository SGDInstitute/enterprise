<?php

namespace Tests\Unit\Mail;

use App\Event;
use App\Mail\InviteUserEmail;
use App\Order;
use App\Ticket;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InviteUserEmailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $invitee = User::factory()->create();
        $coordinator = User::factory()->create(['name' => 'Harry Potter']);

        $event = Event::factory()->published()->create(['title' => 'Quidditch World Cup']);
        $order = Order::factory()->create(['event_id' => $event->id]);
        $ticket = Ticket::factory()->create(['order_id' => $order->id]);

        $message = 'Hello world!';

        $this->email = (new InviteUserEmail($invitee, $coordinator, $ticket, $message))->render();
    }

    /** @test */
    public function email_contains_link_to_set_password()
    {
        $this->assertStringContainsString(url('/password/reset/'), $this->email);
    }

    /** @test */
    public function email_contains_user_who_invited_them()
    {
        $this->assertStringContainsString('Harry Potter', $this->email);
    }

    /** @test */
    public function email_contains_event()
    {
        $this->assertStringContainsString('Quidditch World Cup', $this->email);
    }

    /** @test */
    public function email_contains_message_if_set()
    {
        $this->assertStringContainsString('Hello world!', $this->email);
    }
}
