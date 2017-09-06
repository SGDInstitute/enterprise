<?php

use App\Event;
use App\Order;
use App\Receipt;
use App\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'event_id' => factory(Event::class)->create()->id,
        'user_id' => factory(User::class)->create()->id,
    ];
});

$factory->state(Order::class, 'paid', function (Faker $faker) {
    $this->receipt()->create(factory(Receipt::class)->make());
    return [
        'confirmation_number' => Facades\App\ConfirmationNumber::generate()
    ];
});

$factory->state(Order::class, 'check', function (Faker $faker) {
    return [
        'transaction_id' => '#1234'
    ];
});