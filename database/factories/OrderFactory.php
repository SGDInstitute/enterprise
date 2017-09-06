<?php

use App\Event;
use App\Order;
use App\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'event_id' => factory(Event::class)->create()->id,
        'user_id' => factory(User::class)->create()->id,
    ];
});

$factory->state(Order::class, 'paid', function (Faker $faker) {
    return [
        'transaction_id' => 'charge_id',
        'transaction_date' => \Carbon\Carbon::now(),
        'amount' => 2500,
        'confirmation_number' => Facades\App\ConfirmationNumber::generate()
    ];
});

$factory->state(Order::class, 'check', function (Faker $faker) {
    return [
        'transaction_id' => '#1234'
    ];
});