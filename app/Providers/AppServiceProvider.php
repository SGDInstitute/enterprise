<?php

namespace App\Providers;

use App\Models\EventItem;
use App\Observers\EventItemObserver;
use Illuminate\Support\ServiceProvider;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        EventItem::observe(EventItemObserver::class);

        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function register()
    {
        //
    }
}
