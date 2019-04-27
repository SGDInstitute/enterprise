<?php

namespace Tests\Feature;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Billing\StripePaymentGateway;
use App\Donation;
use App\Mail\DonationEmail;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionDonationTest extends TestCase
{
    use RefreshDatabase;

    public $paymentGateway;

    public function setUp(): void
    {
        parent::setUp();

        $this->paymentGateway = new StripePaymentGateway(getStripeSecret('institute'));
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /** @test */
    function user_can_make_subscription_donation()
    {
        Mail::fake();

        $user = factory(User::class)->create([
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)->json("post", "/donations", [
                'amount' => 25,
                'name' => 'Harry Potter',
                'email' => 'hpotter@hogwarts.edu',
                'subscription' => 'monthly',
                'group' => 'institute',
                'stripeToken' => $this->paymentGateway->getValidTestToken(),
            ]);

        $response->assertStatus(201);

        $donation = Donation::where('email', 'hpotter@hogwarts.edu')->first();

        $this->assertNotNull($donation);
        $this->assertNotNull($donation->hash);
        $this->assertEquals(2500, $donation->amount);
        $this->assertEquals('Harry Potter', $donation->name);
        $this->assertEquals('hpotter@hogwarts.edu', $donation->email);
        $this->assertEquals('monthly-25', $donation->subscription->plan);
        $this->assertNotNull($donation->subscription->next_charge);
        $this->assertTrue($donation->subscription->active);
        $this->assertNotNull($donation->subscription->subscription_id);
        $this->assertNotNull($donation->receipt->transaction_id);
        $this->assertEquals($user->id, $donation->user_id);

        Mail::assertSent(DonationEmail::class, function ($mail) use ($donation) {
            return $mail->hasTo('hpotter@hogwarts.edu')
                && $mail->donation->id === $donation->id;
        });
    }
}
