<?php

return [
    'long_name' => 'Midwest Institute for Sexuality and Gender Diversity',
    'short_name' => 'SGD Institute',
    'address' => 'PO Box 1053, East Lansing, MI 48826-1053',
    'stripe' => [
        'key' => env('INSTITUTE_STRIPE_KEY'),
        'secret' => env('INSTITUTE_STRIPE_SECRET'),
    ],
];