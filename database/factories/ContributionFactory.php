<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Contribution;
use App\Event;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Contribution::class, function (Faker $faker) {
    return [
        'event_id' => function () {
            return factory(Event::class)->create()->id;
        },
        'type' => 'sponsor',
        'title' => 'Premium Sponsor',
        'amount' => 10000,
    ];
});
