<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'name' => 'Leadership Conference',
        'description' => '',
        'timezone' => 'America\Mountain',
        'location' => 'Denver, CO',
        'slug' => 'leadership-conference',
        'start' => Carbon\Carbon::now()->addYear(),
        'end' => Carbon\Carbon::now()->addYear(),
        'open_at' => Carbon\Carbon::now(),
    ];
});
