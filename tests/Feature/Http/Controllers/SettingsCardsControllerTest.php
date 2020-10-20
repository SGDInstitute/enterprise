<?php

namespace Tests\Feature\Http\Controllers;

use App\Billing\PaymentGateway;
use App\Billing\StripePaymentGateway;
use App\Notifications\UpdatedCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SettingsCardsController
 */
class SettingsCardsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_update_their_cc_info()
    {
        $paymentGateway = new StripePaymentGateway(config('institute.stripe.secret'));
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        $user = User::factory()->create([
            'email' => 'andreamswick@gmail.com',
            'institute_stripe_id' => $paymentGateway->getValidTestCustomer(),
        ]);

        Notification::fake();

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->json('PATCH', '/settings/card', [
                'payment_token' => $paymentGateway->getValidTestToken('4000056655665556'),
                'account' => 'institute',
            ]);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'card_last_four' => '5556',
            ],
        ]);

        Notification::assertSentTo(
            $user,
            UpdatedCard::class
        );
    }
}
