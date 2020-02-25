<?php

namespace App\Providers;

use App\Events\ActivitiesUploaded;
use App\Listeners\ImportActivities;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\UserCreated::class => [
            \App\Listeners\CreateProfileForUser::class,
        ],
        'App\Events\TicketCreating' => [
            'App\Listeners\CreateHashForTicket',
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ActivitiesUploaded::class => [
            ImportActivities::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
