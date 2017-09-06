<?php

namespace Tests;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use PHPUnit\Framework\Assert;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();

        TestResponse::macro('assertJsonHasErrors', function($keys = []) {
            Assert::assertArrayHasKey('errors', $this->json());

            foreach (array_wrap($keys) as $key) {
                Assert::assertArrayHasKey($key, $this->json()['errors']);
            }
        });
    }

    public function charge($amount = 5000) {
        $paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        return $paymentGateway->charge($amount, $paymentGateway->getValidTestToken());
    }
}
