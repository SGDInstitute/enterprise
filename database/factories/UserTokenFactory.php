<?php

use Faker\Generator as Faker;

$factory->define(\App\UserToken::class, function (Faker $faker) {
    return [
        'token' => str_random(50),
        'type' => 'magic'
    ];
});

$factory->state(App\UserToken::class, 'expired', function (Faker $faker) {
    return [
        'created_at' => Carbon\Carbon::now()->subMinutes(30),
    ];
});

$factory->state(App\UserToken::class, 'magic', function (Faker $faker) {
    return [
        'type' => 'magic'
    ];
});

$factory->state(App\UserToken::class, 'email', function (Faker $faker) {
    return [
        'type' => 'email'
    ];
});
