<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class Schedule extends Filter
{
    public function apply(Request $request, $query, $value)
    {
        return $query->where('schedule_id', $value);
    }

    public function options(Request $request)
    {
        return \App\Models\Schedule::all()->pluck('id', 'title')->toArray();
    }
}
