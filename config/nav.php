<?php

return [
    'galaxy' => [
        ['name' => 'Dashboard', 'route' => 'galaxy.dashboard', 'icon' => 'heroicon-o-home'],
        ['name' => 'Events', 'route' => 'galaxy.events', 'icon' => 'heroicon-o-calendar'],
        ['name' => 'Surveys', 'route' => 'galaxy.surveys', 'icon' => 'heroicon-o-document'],
        ['name' => 'View All'],
        ['name' => 'Orders', 'route' => 'galaxy.orders', 'icon' => 'heroicon-o-currency-dollar'],
        ['name' => 'Reservations', 'route' => 'galaxy.reservations', 'icon' => 'heroicon-o-cursor-click'],
        ['name' => 'Users', 'route' => 'galaxy.users', 'icon' => 'heroicon-o-user-group'],
    ],
    'app' => [
        'dashboard' => [
            ['name' => 'Order & Reservations', 'route' => 'app.dashboard', 'route-param' => 'orders-reservations', 'icon' => 'heroicon-o-calendar'],
            ['name' => 'Workshop Submissions', 'route' => 'app.dashboard', 'route-param' => 'workshops', 'icon' => 'heroicon-o-light-bulb'],
            ['name' => 'Donations', 'route' => 'app.dashboard', 'route-param' => 'donations', 'icon' => 'heroicon-o-gift'],
            ['name' => 'Settings', 'route' => 'app.dashboard', 'route-param' => 'settings', 'icon' => 'heroicon-o-cog'],
        ]
    ]
];
