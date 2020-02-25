<?php

return [
    'long_name' => 'Midwest Bisexual Lesbian Gay Transgender Ally College Conference',
    'short_name' => 'MBLGTACC',
    'address' => 'PO Box 1053, East Lansing, MI 48826-1053',
    'stripe' => [
        'key' => env('MBLGTACC_STRIPE_KEY'),
        'secret' => env('MBLGTACC_STRIPE_SECRET'),
        'statement' => 'MBLGTACC Conference Registration',
    ],
];
