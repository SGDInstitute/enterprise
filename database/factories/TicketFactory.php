<?php

use App\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'order_id' => function () {
            return factory(App\Order::class)->create()->id;
        },
        'ticket_type_id' => function () {
            return factory(App\TicketType::class)->create()->id;
        },
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});
