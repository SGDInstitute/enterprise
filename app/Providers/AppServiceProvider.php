<?php

namespace App\Providers;

use App\Models\EventItem;
use App\Observers\EventItemObserver;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\HorizonCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        EventItem::observe(EventItemObserver::class);

        Stripe::setApiKey(config('services.stripe.secret'));

        Health::checks([
            OptimizedAppCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
            HorizonCheck::new(),
            DatabaseCheck::new(),
            ScheduleCheck::new()->useCacheStore('schedule-check'),
            UsedDiskSpaceCheck::new()
                ->warnWhenUsedSpaceIsAbovePercentage(60)
                ->failWhenUsedSpaceIsAbovePercentage(80),
        ]);
    }

    public function register(): void
    {
        //
    }
}
