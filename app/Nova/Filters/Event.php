<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class Event extends Filter
{
    public function apply(Request $request, $query, $value)
    {
        return $query->where('event_id', $value);
    }

    public function options(Request $request)
    {
        return \App\Event::all()->pluck('id', 'title')->toArray();
    }
}
