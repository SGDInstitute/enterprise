<?php

namespace Tests\Unit\Billing;

use App\Billing\FakePaymentGateway;
use App\Exceptions\PaymentFailedException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FakePaymentGatewayTest extends TestCase
{

    use PaymentGatewayContractTests;

    protected function getPaymentGateway()
    {
        return new FakePaymentGateway;
    }

    /** @test */
    function subscriptions_with_a_valid_payment_token_are_successful()
    {
        $paymentGateway = $this->getPaymentGateway();

        $newSubscriptions = $paymentGateway->newChargesDuring(function ($paymentGateway) {
            $paymentGateway->subscribe('monthly-25', $paymentGateway->getValidTestCustomer());
        });

        $this->assertCount(1, $newSubscriptions);
        $this->assertEquals('monthly-25', $newSubscriptions[0]['plan']);
    }

    /** @test */
    function subscription_returns_object_with_id_amount_and_card_last_four()
    {
        $paymentGateway = $this->getPaymentGateway();

        $subscription = $paymentGateway->subscribe('monthly-25', $paymentGateway->getValidTestCustomer());

        $this->assertEquals('monthly-25', $subscription->get('plan'));
        $this->assertNotNull($subscription->get('id'));
        $this->assertNotNull($subscription->get('last4'));
    }
}
