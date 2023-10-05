<?php

return [
    'galaxy' => [
        ['name' => 'Dashboard', 'route' => 'galaxy.dashboard', 'icon' => 'heroicon-o-home', 'roles' => ['institute', 'mblgtacc']],
        ['name' => 'Events', 'route' => 'galaxy.events', 'icon' => 'heroicon-o-calendar', 'roles' => ['institute', 'mblgtacc']],
        ['name' => 'Forms', 'route' => 'galaxy.forms', 'icon' => 'heroicon-o-document', 'roles' => ['institute', 'mblgtacc']],
        ['name' => 'View All', 'roles' => ['institute', 'mblgtacc']],
        ['name' => 'Orders', 'route' => 'galaxy.orders', 'icon' => 'heroicon-o-currency-dollar', 'roles' => ['institute', 'mblgtacc']],
        ['name' => 'Reservations', 'route' => 'galaxy.reservations', 'icon' => 'heroicon-o-cursor-arrow-ripple', 'roles' => ['institute', 'mblgtacc']],
        ['name' => 'Donations', 'route' => 'galaxy.donations', 'icon' => 'heroicon-o-gift', 'roles' => ['institute']],
        ['name' => 'Users', 'route' => 'galaxy.users', 'icon' => 'heroicon-o-user-group', 'roles' => ['institute']],
        ['name' => 'Configure', 'roles' => ['institute']],
        ['name' => 'Donations', 'route' => 'galaxy.config.donations', 'icon' => 'heroicon-o-gift', 'roles' => ['institute']],
        ['name' => 'Emails', 'route' => 'galaxy.config.emails', 'icon' => 'heroicon-o-envelope', 'roles' => ['institute']],
    ],
];
