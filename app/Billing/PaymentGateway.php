<?php

namespace App\Billing;

interface PaymentGateway
{
    public function charge($amount, $token);

    public function subscribe($plan, $customer);

    public function getValidTestToken($card);

    public function getValidTestCustomer();

    public function newChargesDuring($callback);

    public function setApiKey($apiKey);

    public function getApiKey();
}
