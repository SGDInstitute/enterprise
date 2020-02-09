<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class ActivityType extends Filter
{
    public function apply(Request $request, $query, $value)
    {
        return $query->where('activity_type_id', $value);
    }

    public function options(Request $request)
    {
        return \App\ActivityType::all()->pluck('id', 'title')->toArray();
    }
}
