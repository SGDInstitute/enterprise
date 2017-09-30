<?php

namespace Tests\Unit;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Donation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DonationTest extends TestCase
{
    use RefreshDatabase;

    public $paymentGateway;

    public function setUp()
    {
        parent::setUp();

        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /** @test */
    function can_make_one_time_donation()
    {
        $request = [
            'amount' => 25,
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
            'stripeToken' => $this->paymentGateway->getValidTestToken(),
        ];

        $donation = Donation::createOneTime($request, $this->charge(2500));

        $this->assertNotNull($donation);
        $this->assertEquals(2500, $donation->amount);
        $this->assertEquals('Harry Potter', $donation->name);
        $this->assertEquals('hpotter@hogwarts.edu', $donation->email);
        $this->assertNotNull($donation->receipt->transaction_id);
    }
}
