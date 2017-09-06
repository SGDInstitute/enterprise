<?php

namespace Tests\Unit\Mail;

use App\Mail\ReceiptEmail;
use App\Order;
use App\Event;
use App\TicketType;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReceiptEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function email_contains_link_to_order_page()
    {
        $order = factory(Order::class)->create();

        $email = (new ReceiptEmail($order))->render();

        $this->assertContains('/orders/' . $order->id, $email);
    }

    /** @test */
    function email_contains_users_name()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create([
            'name' => 'Phoenix Johnson'
        ]);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $email = (new ReceiptEmail($order))->render();

        $this->assertContains('Phoenix Johnson', $email);
    }
}
