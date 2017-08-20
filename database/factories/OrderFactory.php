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
