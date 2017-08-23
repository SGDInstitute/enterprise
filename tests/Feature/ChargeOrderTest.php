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

    public function setUp()
    {
        parent::setUp();
        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

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
                'stripeToken' => $this->paymentGateway->getValidTestToken()
            ]);

        $response
            ->assertStatus(201)
            ->assertSessionHas('flash_notification')
            ->assertJsonStructure([
                'created',
                'order'
            ])
            ->assertJson([
                'created' => true
            ]);
        $order->refresh();
        $this->assertEquals(10000, $paymentGateway->totalCharges());
        $this->assertNotNull($order->transaction_id);
        $this->assertNotNull($order->transaction_date);
    }

    /** @test */
    function order_is_not_marked_as_paid_if_payment_fails()
    {
        $order = factory(Order::class)->create();

        $response = $this->withoutExceptionHandling()
            ->json('POST', "/orders/{$order->id}/charge", [
                'stripeToken' => 'invalid-payment-token',
            ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'created',
                'message'
            ]);
        $order->refresh();
        $this->assertNull($order->transaction_id);
        $this->assertNull($order->transaction_date);
    }
}
