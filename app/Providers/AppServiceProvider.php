<?php

namespace App\Providers;

use App\Models\EventItem;
use App\Observers\EventItemObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        EventItem::observe(EventItemObserver::class);
    }

    public function register()
    {
        //
    }
}
