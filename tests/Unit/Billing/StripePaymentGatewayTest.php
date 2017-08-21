<?php

namespace Tests\Unit\Billing;

use App\Billing\StripePaymentGateway;
use App\Exceptions\PaymentFailedException;
use Stripe\Charge;
use Stripe\Token;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group integration
 */
class StripePaymentGatewayTest extends TestCase
{

    use PaymentGatewayContractTests;

    protected $lastCharge;
    protected $apiKey;

    public function setUp()
    {
        parent::setUp();

        $this->apiKey = config('institute.stripe.secret');
        $this->lastCharge = $this->lastCharge();
    }

    protected function getPaymentGateway()
    {
        return new StripePaymentGateway($this->apiKey);
    }

    private function lastCharge()
    {
        return array_first(Charge::all(
            ['limit' => 1],
            ['api_key' => $this->apiKey]
        )['data']);
    }

    private function newCharges()
    {
        return Charge::all(
            [
                'ending_before' => $this->lastCharge->id,
            ],
            ['api_key' => $this->apiKey]
        )['data'];
    }

    /** @test */
    function charges_with_an_invalid_payment_token_fail()
    {
        $paymentGateway = new StripePaymentGateway($this->apiKey);

        try {
            $paymentGateway->charge(2500, 'invalid-payment-token');
        }
        catch (PaymentFailedException $e) {
            $this->assertCount(0, $this->newCharges());
            return;
        }

        $this->fail('Payment did not fail with an invalid payment token');
    }

    /** @test */
    function can_set_api_key()
    {
        $paymentGateway = new StripePaymentGateway(config('institute.stripe.secret'));

        $paymentGateway->setApiKey(config('mblgtacc.stripe.secret'));

        $this->assertEquals(config('mblgtacc.stripe.secret'), $paymentGateway->getApiKey());
    }
}
