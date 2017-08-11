<?php

use Faker\Generator as Faker;

$factory->define(\App\TicketType::class, function (Faker $faker) {
    return [
        'name' => 'Regular Ticket',
        'description' => 'Regular admission to the event.',
        'cost' => 1500,
        'availability_start' => \Carbon\Carbon::now()->subMonth(),
        'availability_end' => \Carbon\Carbon::now()->addMonth(3),
    ];
});
