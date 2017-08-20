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

    protected $lastCharge;
    protected $apiKey;

    public function setUp()
    {
        parent::setUp();

        $this->apiKey = config('institute.stripe.key');
        $this->lastCharge = $this->lastCharge();
    }

    private function lastCharge()
    {
        return Charge::all(
            ['limit' => 1],
            ['api_key' => $this->apiKey]
        )['data'][0];
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

    private function validToken()
    {
        return Token::create([
            "card" => [
                "number" => "4242424242424242",
                "exp_month" => 1,
                "exp_year" => date('Y') + 1,
                "cvc" => "123"
            ]
        ], ['api_key' => $this->apiKey]);
    }

    /** @test */
    function charges_with_a_valid_payment_token_are_successful()
    {
        $paymentGateway = new StripePaymentGateway($this->apiKey);

        $paymentGateway->charge(2500, $this->validToken());

        $this->assertCount(1, $this->newCharges());
        $this->assertEquals(2500, $this->lastCharge()->amount);
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
}
