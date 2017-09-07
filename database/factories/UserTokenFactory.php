<?php

use Faker\Generator as Faker;

$factory->define(\App\UserToken::class, function (Faker $faker) {
    return [
        'token' => str_random(50)
    ];
});
