<?php

namespace Tests\Feature;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Event;
use App\TicketType;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewOrderReceiptTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_view_receipt()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $order->markAsPaid($this->charge());

        $response = $this->withoutExceptionHandling()
            ->get("/orders/{$order->id}/receipt");

        $response->assertStatus(200)
            ->assertSee('receipt');
    }
}
