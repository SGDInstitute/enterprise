<?php

namespace App\Providers;

use App\Nova\Metrics\NewUsers;
use Laravel\Nova\Nova;
use Laravel\Nova\Cards\Help;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;
use Sgd\CheckinQueue\CheckinQueue;
use Sgd\Projects\Projects;

class NovaServiceProvider extends NovaApplicationServiceProvider
{

    public function boot()
    {
        parent::boot();
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
            new NewUsers,
            new Projects,
        ];
    }

    public function tools()
    {
        return [
            new \Vyuldashev\NovaPermission\NovaPermissionTool,
            new CheckinQueue,
        ];
    }

    public function register()
    {
        //
    }
}
