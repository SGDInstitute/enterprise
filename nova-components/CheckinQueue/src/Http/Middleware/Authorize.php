<?php

namespace Sgd\CheckinQueue\Http\Middleware;

use Sgd\CheckinQueue\CheckinQueue;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(CheckinQueue::class)->authorize($request) ? $next($request) : abort(403);
    }
}
