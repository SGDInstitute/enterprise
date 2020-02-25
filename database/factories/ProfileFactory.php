<?php

use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'pronouns' => Arr::random(['he', 'she', 'they']),
        'sexuality' => Arr::random(['Lesbian', 'Gay', 'Straight', 'Ace']),
        'gender' => Arr::random(['Male', 'Female', 'GNC', 'Trans']),
        'race' => $faker->colorName,
        'college' => 'Illinois State',
        'tshirt' => Arr::random(['S', 'M', 'L', 'XL', 'XXL']),
        'accommodation' => $faker->paragraph(),
    ];
});
