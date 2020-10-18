<?php

namespace App\Billing;

use App\Exceptions\PaymentFailedException;
use App\Exceptions\SubscriptionFailedException;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Error\Card;
use Stripe\Exception\InvalidRequestException;
use Stripe\Subscription;
use Stripe\Token;

class StripePaymentGateway implements PaymentGateway
{
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function charge($amount, $token)
    {
        try {
            $charge = Charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'source' => $token,
            ], ['api_key' => $this->apiKey]);

            return collect(['id' => $charge->id, 'amount' => $charge->amount, 'last4' => $charge->source->last4]);
        } catch (InvalidRequestException $e) {
            throw new PaymentFailedException($e->getMessage());
        } catch (Card $e) {
            throw new PaymentFailedException($e->getMessage());
        }
    }

    public function subscribe($planId, $customerId)
    {
        try {
            $plan = Plan::findOrCreate($planId, $this->getApiKey());
            $customer = Customer::retrieve($customerId, ['api_key' => $this->apiKey]);

            $subscription = Subscription::create([
                'customer' => $customer->id,
                'items' => [
                    [
                        'plan' => $plan->id,
                    ],
                ],
            ], ['api_key' => $this->apiKey]);

            return collect([
                'id' => $subscription->id,
                'plan' => $subscription->plan->id,
                'last4' => $customer->sources['data'][0]['last4'],
                'next_charge' => Carbon::createFromTimestamp($subscription->current_period_end)->toDateTimeString(),
            ]);
        } catch (InvalidRequestException $e) {
            throw new SubscriptionFailedException;
        }
    }

    public function getValidTestToken($card = '4242424242424242')
    {
        return Token::create([
            'card' => [
                'number' => $card,
                'exp_month' => 1,
                'exp_year' => date('Y') + 1,
                'cvc' => '123',
            ],
        ], ['api_key' => $this->apiKey])->id;
    }

    public function getValidTestCustomer()
    {
        return Customer::create([
            'description' => 'Customer for hpotter@hogwarts.edu',
            'source' => $this->getValidTestToken(),
        ], ['api_key' => $this->apiKey])->id;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function newChargesDuring($callback)
    {
        $latestCharge = $this->lastCharge();
        $callback($this);

        return $this->newChargesSince($latestCharge)->pluck('amount');
    }

    private function lastCharge()
    {
        return Arr::first(Charge::all(
            ['limit' => 1],
            ['api_key' => $this->apiKey]
        )['data']);
    }

    private function newChargesSince($charge = null)
    {
        $newCharges = Charge::all(
            [
                'ending_before' => $charge ? $charge->id : null,
            ],
            ['api_key' => $this->apiKey]
        )['data'];

        return collect($newCharges);
    }
}
