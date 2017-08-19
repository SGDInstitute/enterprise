<?php

use Faker\Generator as Faker;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'pronouns' => 'he, him, his',
        'sexuality' => 'Straight',
        'gender' => 'Male',
        'race' => 'White',
        'college' => 'Hogwarts',
        'tshirt' => 'M',
        'accommodation' => $faker->paragraph(),
    ];
});
