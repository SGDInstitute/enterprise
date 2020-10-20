<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;

class NewUsers extends Value
{
    public function calculate(Request $request)
    {
        return $this->count($request, User::class);
    }

    public function ranges()
    {
        return [
            30 => '30 Days',
            60 => '60 Days',
            365 => '365 Days',
            'TODAY' => 'Today',
            'MTD' => 'Month To Date',
            'QTD' => 'Quarter To Date',
            'YTD' => 'Year To Date',
        ];
    }

    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    public function uriKey()
    {
        return 'new-users';
    }
}
