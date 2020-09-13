<?php

namespace Tests\Unit;

use App\Billing\StripePaymentGateway;
use App\Event;
use App\TicketType;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceiptTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_charge_for_receipt()
    {
        $paymentGateway = new StripePaymentGateway(config('institute.stripe.secret'));
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        $user = User::factory()->create();
        $upcomingEvent = Event::factory()->published()->create([
            'start' => Carbon::now()->addMonth(2),
        ]);
        $ticketType = $upcomingEvent->ticket_types()->save(TicketType::factory()->make());
        $order = $upcomingEvent->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $charge = $paymentGateway->charge($order->amount, $paymentGateway->getValidTestToken());

        $order->markAsPaid($charge);

        $this->assertNotNull($order->fresh()->receipt->charge());
    }
}
