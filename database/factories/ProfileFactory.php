<?php

use Faker\Generator as Faker;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'pronouns' => array_random(["he", "she", "they"]),
        'sexuality' => array_random(["Lesbian", "Gay", "Straight", "Ace"]),
        'gender' => array_random(["Male", "Female", "GNC", "Trans"]),
        'race' => $faker->colorName,
        'college' => 'Illinois State',
        'tshirt' => array_random(["S", "M", "L", "XL", "XXL"]),
        'accommodation' => $faker->paragraph(),
    ];
});
