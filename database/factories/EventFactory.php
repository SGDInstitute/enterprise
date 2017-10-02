<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'title' => 'Leadership Conference',
        'slug' => 'leadership-conference',
        'stripe' => 'institute',
        'subtitle' => 'Learn something new every day',
        'timezone' => 'America/Denver',
        'place' => 'University of Colorado',
        'location' => 'Denver, CO',
        'start' => Carbon\Carbon::now()->addYear(),
        'end' => Carbon\Carbon::now()->addYear()->addDay(2),
        'links' => [
            ['icon' => 'twitter', 'link' => 'https://twitter.com/leadership', 'order' => 1],
            ['icon' => 'facebook', 'link' => 'https://www.facebook.com/leadership/', 'order' => 2],
            ['icon' => 'instagram', 'link' => 'https://www.instagram.com/leadership', 'order' => 3],
            ['icon' => 'snapchat-ghost', 'link' => 'https://www.snapchat.com/add/leadership', 'order' => 4],
            ['icon' => 'website', 'link' => 'https://leadership.org', 'order' => 5],
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

$factory->state(App\Event::class, 'past', function (Faker $faker) {
    return [
        'start' => \Carbon\Carbon::parse('-1 year'),
        'end' => \Carbon\Carbon::parse('-1 year')->addDays(2),
    ];
});