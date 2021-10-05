<?php

namespace App\Providers;

use App\Models\Event;
use App\View\Composers\ProfileComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('layouts/app', function ($view) {
            if (auth()->check()) {
                $events = Event::where('settings->allow_checkin', true)->select('id', 'name', 'slug', 'start', 'end')->where('end', '>', now())->get();

                if ($events->count() > 0) {
                    $links = $events->filter(fn ($event) => auth()->user()->ticketForEvent($event) !== null)
                        ->map(fn ($event) => ['text' => $event->name . " Program", 'url' => route('app.program', $event)]);

                    $view->with('links', $links);
                }
            }
        });
    }
}
