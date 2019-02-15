<?php

use Faker\Generator as Faker;

$factory->define(\App\Queue::class, function (Faker $faker) {
    return [
        'batch' => 'ABCDE',
        'ticket_id' => factory(\App\Ticket::class)->create(),
        'name' => $faker->name,
        'pronouns' => 'they/them',
        'college' => 'Hogwarts Edu.',
        'tshirt' => 'S',
        'order_created' => '2019-01-15 00:00:00',
        'order_paid' => '2019-01-15 00:00:00',
    ];
});
