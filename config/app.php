<?php

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Facade;

return [

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Laravel Framework Service Providers...
         */

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\FilamentServiceProvider::class,
        App\Providers\HorizonServiceProvider::class,
        App\Providers\Filament\AdminPanelProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\ViewServiceProvider::class,
    ])->toArray(),

];
