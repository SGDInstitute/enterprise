<?php

namespace Tests\Unit;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Donation;
use App\Event;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DonationTest extends TestCase
{
    use RefreshDatabase;

    public $paymentGateway;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /** @test */
    public function can_make_one_time_donation()
    {
        $request = [
            'amount' => 25,
            'group' => 'institute',
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
            'subscription' => 'no',
            'stripeToken' => $this->paymentGateway->getValidTestToken(),
        ];

        $donation = Donation::createOneTime($request, $this->charge(2500));

        $this->assertNotNull($donation);
        $this->assertEquals(2500, $donation->amount);
        $this->assertEquals('Harry Potter', $donation->name);
        $this->assertEquals('hpotter@hogwarts.edu', $donation->email);
        $this->assertNotNull($donation->receipt->transaction_id);
    }

    /** @test */
    public function can_make_donation_with_subscription()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $request = [
            'amount' => 25,
            'group' => 'institute',
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
            'subscription' => 'monthly',
            'stripeToken' => $this->paymentGateway->getValidTestToken(),
        ];
        $subscription = $this->paymentGateway->subscribe("{$request['subscription']}-{$request['amount']}", $this->paymentGateway->getValidTestCustomer());

        $donation = Donation::createWithSubscription($request, $subscription);

        $this->assertNotNull($donation);
        $this->assertEquals(2500, $donation->amount);
        $this->assertEquals('Harry Potter', $donation->name);
        $this->assertEquals('hpotter@hogwarts.edu', $donation->email);
        $this->assertNotNull($donation->receipt->transaction_id);
        $this->assertEquals('monthly-25', $donation->subscription->plan);
        $this->assertNotNull($donation->subscription->next_charge);
        $this->assertTrue($donation->subscription->active);
        $this->assertNotNull($donation->subscription->subscription_id);
        $this->assertNotNull($donation->receipt->transaction_id);
        $this->assertEquals($user->id, $donation->user_id);
    }

    /** @test */
    public function find_by_hash()
    {
        $donation = factory(Donation::class)->create();

        $foundDonation = Donation::findByHash($donation->hash);

        $this->assertEquals($donation->id, $foundDonation->id);
    }
}
