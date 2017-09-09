<?php

namespace Tests\Unit\Mail;

use App\Event;
use App\Mail\InviteUserEmail;
use App\Order;
use App\Ticket;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InviteUserEmailTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $invitee = factory(User::class)->create();
        $coordinator = factory(User::class)->create(['name' => 'Harry Potter']);

        $event = factory(Event::class)->states('published')->create(['title' => 'Quidditch World Cup']);
        $order = factory(Order::class)->create(['event_id' => $event->id]);
        $ticket = factory(Ticket::class)->create(['order_id' => $order->id]);

        $message = 'Hello world!';

        $this->email = (new InviteUserEmail($invitee, $coordinator, $ticket, $message))->render();
    }

    /** @test */
    function email_contains_link_to_set_password()
    {
        $this->assertContains(url('/password/reset/'), $this->email);
    }

    /** @test */
    function email_contains_user_who_invited_them()
    {
        $this->assertContains('Harry Potter', $this->email);
    }

    /** @test */
    function email_contains_event()
    {
        $this->assertContains('Quidditch World Cup', $this->email);
    }

    /** @test */
    function email_contains_message_if_set()
    {
        $this->assertContains('Hello world!', $this->email);
    }
}
