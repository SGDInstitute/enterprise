<?php

namespace Tests\Feature;

use App\Event;
use App\TicketType;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargeOrderTest extends TestCase
{
    /** @test */
    function customer_can_pay_for_order_with_card()
    {
        // Arrange
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
        ]));
        $user = factory(User::class)->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        // Act
        $response = $this->json('POST', "/orders/{$order->id}/charge", [
            'payment_token' => $paymentGateway->getValidTestToken()
        ]);

        // Assert
        $response->assertStatus(200);
        $order->fresh();
        $this->assertEquals(10000, $paymentGateway->totalCharges());
        $this->assertNotNull($order->transaction_id);
    }
}
