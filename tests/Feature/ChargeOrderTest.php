<?php

namespace Tests\Feature;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Event;
use App\Order;
use App\TicketType;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargeOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function customer_can_pay_for_order_with_card()
    {
        $paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
        ]));
        $user = factory(User::class)->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $response = $this->withoutExceptionHandling()
            ->json('POST', "/orders/{$order->id}/charge", [
                'payment_token' => $paymentGateway->getValidTestToken()
            ]);

        $response->assertStatus(201);
        $order->refresh();
        $this->assertEquals(10000, $paymentGateway->totalCharges());
        $this->assertNotNull($order->transaction_id);
        $this->assertNotNull($order->transaction_date);
    }
}
