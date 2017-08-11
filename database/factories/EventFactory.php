<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'title' => 'Leadership Conference',
        'slug' => 'leadership-conference',
        'subtitle' => 'Learn something new every day',
        'description' => '',
        'timezone' => 'America\Mountain',
        'place' => 'University of Colorado',
        'location' => 'Denver, CO',
        'start' => Carbon\Carbon::now()->addYear(),
        'end' => Carbon\Carbon::now()->addYear()->addDay(2),
        'links' => [
            'facebook' => 'https://facebook.com/leadership',
            'twitter' => 'https://twitter.com/leadership',
            'instagram' => 'https://instagram.com/leadership',
            'external-link' => 'https://leadership.org',
        ],
    ];
});
