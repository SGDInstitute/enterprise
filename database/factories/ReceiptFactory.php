<?php

use App\Receipt;
use Faker\Generator as Faker;

$factory->define(Receipt::class, function (Faker $faker) {
    return [
        'transaction_id' => 'charge_id',
        'amount' => 2500,
    ];
});
