<?php

namespace App\Billing;


use App\Exceptions\PaymentFailedException;
use Stripe\Charge;
use Stripe\Error\InvalidRequest;

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
            return Charge::create([
                "amount" => $amount,
                "currency" => "usd",
                "source" => $token,
            ], ['api_key' => $this->apiKey]);
        }
        catch (InvalidRequest $e) {
            throw new PaymentFailedException;
        }
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