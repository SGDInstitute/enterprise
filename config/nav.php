<?php

return [
    'galaxy' => [
        ['name' => 'Dashboard', 'route' => 'galaxy.dashboard', 'icon' => 'heroicon-o-home'],
        ['name' => 'Events', 'route' => 'galaxy.events', 'icon' => 'heroicon-o-calendar'],
    ],
    'app' => [
        'dashboard' => [
            ['name' => 'Order & Reservations', 'route' => 'app.dashboard', 'route-param' => 'orders-reservations', 'icon' => 'heroicon-o-calendar'],
            ['name' => 'Workshop Submissions', 'route' => 'app.dashboard', 'route-param' => 'workshops', 'icon' => 'heroicon-o-light-bulb'],
            ['name' => 'Donations', 'route' => 'app.dashboard', 'route-param' => 'donations', 'icon' => 'heroicon-o-gift'],
        ]
    ]
];
