<?php

namespace App\Providers;

use App\Nova\Metrics\EventTicketsFilled;
use App\Nova\Metrics\EventTicketsStatus;
use App\Nova\Metrics\NewUsers;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Sgd\CheckinQueue\CheckinQueue;
use Sgd\Projects\Projects;
use Wehaa\CustomLinks\CustomLinks;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    protected function registerExceptionHandler()
    {
        // Don't register Nova's exception handler
    }

    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->hasRole('institute') || $user->hasRole('mblgtacc_planner') || $user->hasRole('developer');
        });
    }

    protected function cards()
    {
        return [
            (new Projects)->width('1/2'),
            (new NewUsers)->width('1/2'),
            (new EventTicketsStatus)->width('1/2'),
            (new EventTicketsFilled)->width('1/2'),
        ];
    }

    public function tools()
    {
        return [
            new CustomLinks(),
            new \Vyuldashev\NovaPermission\NovaPermissionTool,
            new CheckinQueue,
        ];
    }

    public function register()
    {
        //
    }
}
