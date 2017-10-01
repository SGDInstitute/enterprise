<?php

namespace Tests\Feature;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Donation;
use App\Mail\DonationEmail;
use App\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OneTimeDonationTest extends TestCase
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
    function visitor_can_make_one_time_donation()
    {
        Mail::fake();

        $response = $this->withoutExceptionHandling()->json("post", "/donations", [
                'amount' => 15,
                'name' => 'Harry Potter',
                'email' => 'hpotter@hogwarts.edu',
                'subscription' => 'no',
                'stripeToken' => $this->paymentGateway->getValidTestToken(),
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'donation', 'redirect'
            ]);

        $donation = Donation::where('email', 'hpotter@hogwarts.edu')->first();

        $this->assertNotNull($donation);
        $this->assertEquals(1500, $this->paymentGateway->totalCharges());
        $this->assertEquals(1500, $donation->amount);
        $this->assertEquals('Harry Potter', $donation->name);
        $this->assertEquals('hpotter@hogwarts.edu', $donation->email);
        $this->assertNotNull($donation->hash);
        $this->assertNull($donation->user_id);
        $this->assertNotNull($donation->receipt->transaction_id);

        Mail::assertSent(DonationEmail::class, function ($mail) use ($donation) {
            return $mail->hasTo('hpotter@hogwarts.edu')
                && $mail->donation->id === $donation->id;
        });
    }

    /** @test */
    function user_can_make_one_time_donation()
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
                'subscription' => 'no',
                'stripeToken' => $this->paymentGateway->getValidTestToken(),
            ]);

        $response->assertStatus(201);

        $donation = Donation::where('email', 'hpotter@hogwarts.edu')->first();

        $this->assertNotNull($donation);
        $this->assertEquals(2500, $this->paymentGateway->totalCharges());
        $this->assertEquals(2500, $donation->amount);
        $this->assertEquals('Harry Potter', $donation->name);
        $this->assertEquals('hpotter@hogwarts.edu', $donation->email);
        $this->assertNotNull($donation->receipt->transaction_id);
        $this->assertEquals($user->id, $donation->user_id);

        Mail::assertSent(DonationEmail::class, function ($mail) use ($donation) {
            return $mail->hasTo('hpotter@hogwarts.edu')
                && $mail->donation->id === $donation->id;
        });
    }

    /** @test */
    function can_make_one_time_donation_with_company_information()
    {
        Mail::fake();

        $response = $this->withoutExceptionHandling()->json("post", "/donations", [
            'amount' => 15,
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
            'subscription' => 'no',
            'company' => 'Hogwarts School of Witchcraft and Wizardry',
            'tax_id' => 123123123,
            'stripeToken' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(201);

        $donation = Donation::where('email', 'hpotter@hogwarts.edu')->first();

        $this->assertNotNull($donation);
        $this->assertEquals('Hogwarts School of Witchcraft and Wizardry', $donation->company);
        $this->assertEquals(123123123, $donation->tax_id);

        Mail::assertSent(DonationEmail::class, function ($mail) use ($donation) {
            return $mail->hasTo('hpotter@hogwarts.edu')
                && $mail->donation->id === $donation->id;
        });
    }

    /** @test */
    function donation_is_not_created_if_charge_fails()
    {
        $response = $this->withoutExceptionHandling()->json("post", "/donations", [
            'amount' => 15,
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
            'subscription' => 'no',
            'stripeToken' => 'invalid-payment-token',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'created',
                'message'
            ]);

        $this->assertNull(Donation::where('email', 'hpotter@hogwarts.edu')->first());
    }

    /** @test */
    function amount_is_required()
    {
        $response = $this->json("post", "/donations", [
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
            'subscription' => 'no',
            'stripeToken' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('amount');
    }

    /** @test */
    function amount_must_be_at_least_five()
    {
        $response = $this->json("post", "/donations", [
            'amount' => 4,
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
            'subscription' => 'no',
            'stripeToken' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('amount');
    }

    /** @test */
    function amount_must_less_than_a_million()
    {
        $response = $this->json("post", "/donations", [
            'amount' => 1000000,
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
            'subscription' => 'no',
            'stripeToken' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('amount');
    }

    /** @test */
    function name_is_required()
    {
        $response = $this->json("post", "/donations", [
            'amount' => 10,
            'email' => 'hpotter@hogwarts.edu',
            'subscription' => 'no',
            'stripeToken' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('name');
    }

    /** @test */
    function email_is_required()
    {
        $response = $this->json("post", "/donations", [
            'amount' => 10,
            'name' => 'Harry Potter',
            'subscription' => 'no',
            'stripeToken' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('email');
    }

    /** @test */
    function company_and_tax_id_are_required_if_is_company_is_true()
    {
        $response = $this->json("post", "/donations", [
            'amount' => 10,
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
            'subscription' => 'no',
            'is_company' => true,
            'stripeToken' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors(['company', 'tax_id']);
    }
}
