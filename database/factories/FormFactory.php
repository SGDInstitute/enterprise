<?php

use Faker\Generator as Faker;

$factory->define(App\Form::class, function (Faker $faker) {
    return [
        'name'      => 'Test Survey',
        'slug'      => 'test-survey',
        'start'     => $faker->date(),
        'end'       => $faker->date(),
        'is_public' => true,
        'form'      => '[
                {
                  "id": 1,
                  "question": "Hello world.",
                  "type": "textarea",
                  "required": false,
                }
            ]',
    ];
});
