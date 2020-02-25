<?php

namespace Tests\Feature\Http\Controllers;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Event;
use App\Mail\ReceiptEmail;
use App\Order;
use App\TicketType;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrderChargeController
 */
class OrderChargeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /** @test */
    public function customer_can_pay_for_order_with_card()
    {
        Mail::fake();

        $paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
        ]));
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $response = $this->withoutExceptionHandling()->actingAs($user)
            ->json('POST', "/orders/{$order->id}/charge", [
                'payment_token' => $this->paymentGateway->getValidTestToken(),
            ]);

        $response
            ->assertStatus(201)
            ->assertSessionHas('flash_notification')
            ->assertJsonStructure([
                'created',
                'order',
            ])
            ->assertJson([
                'created' => true,
            ]);
        $order->refresh();
        $this->assertEquals(10000, $paymentGateway->totalCharges());
        $this->assertNotNull($order->receipt->transaction_id);

        Mail::assertSent(ReceiptEmail::class, function ($mail) use ($order) {
            return $mail->hasTo('jo@example.com')
                && $mail->order->id === $order->id;
        });
    }

    /** @test */
    public function order_is_not_marked_as_paid_if_payment_fails()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->json('POST', "/orders/{$order->id}/charge", [
                'stripeToken' => 'invalid-payment-token',
            ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'created',
                'message',
            ]);
        $order->refresh();
        $this->assertNull($order->receipt);
    }
}
