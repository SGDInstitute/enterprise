<?php

use App\Event;
use App\Order;
use App\Receipt;
use App\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'event_id' => function () {
            return factory(Event::class)->create()->id;
        },
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->state(Order::class, 'paid', function (Faker $faker) {
    return [
        'confirmation_number' => Facades\App\ConfirmationNumber::generate(),
    ];
});

$factory->state(Order::class, 'check', function (Faker $faker) {
    return [
        'transaction_id' => '#1234',
    ];
});
