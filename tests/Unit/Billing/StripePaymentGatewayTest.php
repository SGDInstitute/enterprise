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

    protected function getPaymentGateway()
    {
        return new StripePaymentGateway(config('institute.stripe.secret'));
    }
}
