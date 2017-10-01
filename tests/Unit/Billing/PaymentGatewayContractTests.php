<?php

namespace Tests\Unit\Billing;

use App\Exceptions\PaymentFailedException;
use App\Exceptions\SubscriptionFailedException;

trait PaymentGatewayContractTests
{
    abstract protected function getPaymentGateway();

    /** @test */
    function can_fetch_charges_created_during_a_callback()
    {
        $paymentGateway = $this->getPaymentGateway();

        $paymentGateway->charge(2500, $paymentGateway->getValidTestToken());
        $paymentGateway->charge(3000, $paymentGateway->getValidTestToken());

        $newCharges = $paymentGateway->newChargesDuring(function ($paymentGateway) {
            $paymentGateway->charge(4000, $paymentGateway->getValidTestToken());
            $paymentGateway->charge(5000, $paymentGateway->getValidTestToken());
        });

        $this->assertCount(2, $newCharges);
        $this->assertEquals([5000, 4000], $newCharges->all());

    }

    /** @test */
    function charges_with_a_valid_payment_token_are_successful()
    {
        $paymentGateway = $this->getPaymentGateway();

        $newCharges = $paymentGateway->newChargesDuring(function ($paymentGateway) {
            $paymentGateway->charge(2500, $paymentGateway->getValidTestToken());
        });

        $this->assertCount(1, $newCharges);
        $this->assertEquals(2500, $newCharges->sum());
    }

    /** @test */
    function charges_with_an_invalid_payment_token_fail()
    {
        $paymentGateway = $this->getPaymentGateway();

        $newCharges = $paymentGateway->newChargesDuring(function ($paymentGateway) {
            try {
                $paymentGateway->charge(2500, 'invalid-payment-token');
            } catch (PaymentFailedException $e) {
                return;
            }

            $this->fail('Payment did not fail with an invalid payment token');
        });

        $this->assertCount(0, $newCharges);
    }

    /** @test */
    function can_set_api_key()
    {
        $paymentGateway = $this->getPaymentGateway();

        $paymentGateway->setApiKey(config('mblgtacc.stripe.secret'));

        $this->assertEquals(config('mblgtacc.stripe.secret'), $paymentGateway->getApiKey());
    }

    /** @test */
    function charge_returns_object_with_id_amount_and_card_last_four()
    {
        $paymentGateway = $this->getPaymentGateway();

        $charge = $paymentGateway->charge(2500, $paymentGateway->getValidTestToken());

        $this->assertEquals(2500, $charge->get('amount'));
        $this->assertNotNull($charge->get('id'));
        $this->assertNotNull($charge->get('last4'));
    }

    /** @test */
    function subscriptions_with_a_valid_payment_token_are_successful()
    {
        $paymentGateway = $this->getPaymentGateway();

        $subscription = $paymentGateway->subscribe('monthly-25', $paymentGateway->getValidTestCustomer());

        $this->assertNotNull($subscription->get('id'));
        $this->assertEquals('monthly-25', $subscription->get('plan'));
        $this->assertNotNull($subscription->get('last4'));
    }

    /** @test */
    function subscriptions_with_an_invalid_customer_fail()
    {
        $paymentGateway = $this->getPaymentGateway();

        try {
            $paymentGateway->subscribe('monthly-25', 'invalid-customer');
        } catch (SubscriptionFailedException $e) {
            $this->assertNotNull($e);
            return;
        }

        $this->fail('Payment did not fail with an invalid payment token');
    }

    /** @test */
    function subscription_returns_object_with_id_plan_and_card_last_four()
    {
        $paymentGateway = $this->getPaymentGateway();

        $subscription = $paymentGateway->subscribe('monthly-25', $paymentGateway->getValidTestCustomer());

        $this->assertEquals('monthly-25', $subscription->get('plan'));
        $this->assertNotNull($subscription->get('id'));
        $this->assertNotNull($subscription->get('last4'));
    }
}