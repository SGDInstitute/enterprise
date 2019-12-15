<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Response::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'form_id' => function () {
            return factory(App\Form::class)->create()->id;
        },
        'email' => $faker->safeEmail,
        'responses' => $faker->text,
        'request' => $faker->text,
    ];
});
