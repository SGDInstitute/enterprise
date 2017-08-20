<?php

namespace Tests\Unit\Billing;

use App\Billing\StripePaymentGateway;
use Stripe\Charge;
use Stripe\Token;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StripePaymentGatewayTest extends TestCase
{
    /** @test */
    function charges_with_a_valid_payment_token_are_successful()
    {
        $paymentGateway = new StripePaymentGateway;

        $token = Token::create([
            "card" => [
                "number" => "4242424242424242",
                "exp_month" => 1,
                "exp_year" => date('Y') + 1,
                "cvc" => "123"
            ]
        ], ['api_key' => config('institute.stripe.key')]);

        $paymentGateway->charge(2500, $token->id);

        $lastCharge = Charge::all(
            ['limit' => 1],
            ['api_key' => config('institute.stripe.key')]
        )['data'][0];

        $this->assertEquals(2500, $lastCharge->amount);
    }
}
