<?php

namespace Tests\Feature\Api;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Models\Contribution;
use App\Models\Donation;
use App\Models\Event;
use App\Mail\ContributionEmail;
use App\Mail\DonationEmail;
use App\Models\Queue;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CanCreateDonationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /** @test */
    public function user_can_make_a_contribution_donation()
    {
        Mail::fake();
        $user = User::factory()->create(['name' => 'Harry Potter', 'email' => 'hpotter@hogwarts.edu']);
        $event = Event::factory()->create();
        $sponsorship = Contribution::factory()->create(['event_id' => $event->id, 'type' => 'sponsor', 'amount' => 100000]);
        $vendor = Contribution::factory()->create(['event_id' => $event->id, 'type' => 'vendor', 'amount' => 20000]);
        $vendor->quantity = 1;
        $ad = Contribution::factory()->create(['event_id' => $event->id, 'type' => 'ad', 'amount' => 10000]);
        $ad->quantity = 1;
        Passport::actingAs($user);

        $response = $this->withoutExceptionHandling()->actingAs($user)->json('post', '/api/donations', [
            'contributions' => [
                'amount' => 1000,
                'ads' => [$ad],
                'vendor' => $vendor,
                'sponsorship' => $sponsorship,
                'type' => 'sponsor',
            ],
            'event_id' => $event->id,
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $donation = Donation::where('email', 'hpotter@hogwarts.edu')->first();

        $this->assertNotNull($donation);
        $this->assertEquals(130000, $this->paymentGateway->totalCharges());
        $this->assertEquals(130000, $donation->amount);
        $this->assertEquals('Harry Potter', $donation->name);
        $this->assertEquals('hpotter@hogwarts.edu', $donation->email);
        $this->assertNotNull($donation->hash);
        $this->assertEquals($user->id, $donation->user_id);
        $this->assertNotNull($donation->receipt->transaction_id);
        $this->assertNotNull($donation->contributions);
        $this->assertCount(3, $donation->contributions);

        Mail::assertSent(ContributionEmail::class, function ($mail) use ($donation) {
            return $mail->hasTo('hpotter@hogwarts.edu')
                && $mail->donation->id === $donation->id;
        });
    }
}
