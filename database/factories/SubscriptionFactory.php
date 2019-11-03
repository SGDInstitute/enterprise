<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Subscription::class, function (Faker $faker) {
    return [
        'donation_id' => function () {
            return factory(App\Donation::class)->create()->id;
        },
        'plan' => $faker->word,
        'next_charge' => $faker->dateTime(),
        'subscription_id' => $faker->word,
        'active' => $faker->boolean,
        'ended_at' => $faker->dateTime(),
    ];
});
