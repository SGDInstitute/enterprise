<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Billing\StripePaymentGateway;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use App\TicketType;
use App\Event;
use App\User;

class ReceiptTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_charge_for_receipt()
    {
        $paymentGateway = new StripePaymentGateway(config('institute.stripe.secret'));
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        $user = factory(User::class)->create();
        $upcomingEvent = factory(Event::class)->states('published')->create([
            'start' => Carbon::now()->addMonth(2),
        ]);
        $ticketType = $upcomingEvent->ticket_types()->save(factory(TicketType::class)->make());
        $order = $upcomingEvent->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $charge = $paymentGateway->charge($order->amount, $paymentGateway->getValidTestToken());

        $order->markAsPaid($charge);

        $this->assertNotNull($order->fresh()->receipt->charge());
    }
}
