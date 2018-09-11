<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() === null) {
            return redirect('/login');
        } elseif ($request->user()->hasPermissionTo('view_dashboard')) {
            return $next($request);
        } else {
            return redirect('/home');
        }
    }
}
