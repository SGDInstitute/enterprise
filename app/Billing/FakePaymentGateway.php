<?php

namespace App\Billing;


use App\Exceptions\PaymentFailedException;
use App\Exceptions\SubscriptionFailedException;

class FakePaymentGateway implements PaymentGateway
{
    private $charges;

    private $apiKey;

    public function __construct()
    {
        $this->charges = collect();
    }

    public function getValidTestToken()
    {
        return 'valid-token';
    }

    public function getValidTestCustomer()
    {
        return 'valid-customer';
    }

    public function charge($amount, $token)
    {
        if($token !== $this->getValidTestToken()) {
            throw new PaymentFailedException();
        }

        $this->charges[] = $amount;

        return collect(['id' => 'charge_id', 'amount' => $amount, 'last4' => '1234']);
    }

    public function subscribe($plan, $customer)
    {
        if($customer !== $this->getValidTestCustomer()) {
            throw new SubscriptionFailedException();
        }

        $this->charges[] = ['plan' => $plan, 'customer' => $customer];

        return collect(['id' => 'subscription_id', 'plan' => $plan, 'last4' => '1234']);
    }

    public function newChargesDuring($callback)
    {
        $chargesFrom = $this->charges->count();
        $callback($this);
        return $this->charges->slice($chargesFrom)->reverse()->values();
    }

    public function totalCharges()
    {
        return $this->charges->sum();
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }
}