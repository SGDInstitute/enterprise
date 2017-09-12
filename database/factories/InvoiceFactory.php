<?php

use Faker\Generator as Faker;

$factory->define(App\Invoice::class, function (Faker $faker) {
    return [
        'order_id' => function () {
            return factory(App\Order::class)->create()->id;
        },
        'name' => $faker->name,
        'email' => $faker->email,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->stateAbbr,
        'zip' => $faker->postcode,
    ];
});
