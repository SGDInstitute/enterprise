<?php

namespace App\Providers;

use App\Events\ShiftsFellBelowLimit;
use App\Events\WorkshopStatusChanged;
use App\Listeners\CancelWorkshop;
use App\Listeners\DeleteCompedOrder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        WorkshopStatusChanged::class => [
            CancelWorkshop::class,
        ],
        ShiftsFellBelowLimit::class => [
            DeleteCompedOrder::class,
        ],
    ];

    public function boot(): void
    {
        // EventBadgeQueue::observe(QueueObserver::class);
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
