<?php

namespace App\Billing;

use Stripe\Error\InvalidRequest;

class Plan
{

    public static function findOrCreate($plan, $key)
    {
        try {
            $plan = \Stripe\Plan::retrieve($plan, ['api_key' => $key]);
        } catch (InvalidRequest $e) {
            $duration = explode('-', $plan)[0];
            $amount = explode('-', $plan)[1] * 100;

            if ($duration === 'quarterly') {
                $interval = 'month';
                $interval_count = 3;
            } elseif ($duration === 'yearly') {
                $interval = 'year';
                $interval_count = 1;
            } else {
                $interval = 'month';
                $interval_count = 1;
            }

            $plan = \Stripe\Plan::create([
                "amount"         => $amount,
                "interval"       => $interval,
                "interval_count" => $interval_count,
                "name"           => $plan,
                "currency"       => "usd",
                "id"             => $plan,
            ], ['api_key' => $key]);
        }

        return $plan;
    }
}
