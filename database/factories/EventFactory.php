<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'title' => 'Leadership Conference',
        'slug' => 'leadership-conference',
        'subtitle' => 'Learn something new every day',
        'timezone' => 'America/Denver',
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

$factory->state(App\Event::class, 'published', function (Faker $faker) {
    return [
        'published_at' => \Carbon\Carbon::parse('-1 week'),
    ];
});

$factory->state(App\Event::class, 'unpublished', function (Faker $faker) {
    return [
        'published_at' => null,
    ];
});

$factory->state(App\Event::class, 'future', function (Faker $faker) {
    return [
        'published_at' => \Carbon\Carbon::parse('+1 month'),
    ];
});