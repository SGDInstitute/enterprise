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
}
