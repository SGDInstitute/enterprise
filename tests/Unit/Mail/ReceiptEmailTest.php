<?php

namespace Tests\Unit\Mail;

use App\Event;
use App\Mail\ReceiptEmail;
use App\Order;
use App\TicketType;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceiptEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function email_contains_link_to_order_page()
    {
        $order = factory(Order::class)->create();
        $order->markAsPaid($this->charge());

        $email = (new ReceiptEmail($order))->render();

        $this->assertStringContainsString('/orders/'.$order->id, $email);
    }

    /** @test */
    public function email_contains_users_name()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create([
            'name' => 'Phoenix Johnson',
        ]);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);
        $order->markAsPaid($this->charge());

        $email = (new ReceiptEmail($order))->render();

        $this->assertStringContainsString('Phoenix Johnson', $email);
    }
}
