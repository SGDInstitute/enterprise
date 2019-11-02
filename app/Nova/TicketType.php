<?php

namespace App\Nova;

use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class TicketType extends Resource
{

    public static $model = \App\TicketType::class;

    public static $title = 'name';

    public static $search = [
        'id',
    ];

    public static $group = 'Registration';

    public static function label()
    {
        return __('Ticket Type');
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Event'),
            Text::make('Name')->sortable(),
            Textarea::make('Description')->sortable(),
            Currency::make('Cost')
                ->displayUsing(function ($cost) {
                    return $cost / 100;
                })->format('%.2n'),
            DateTime::make('Availability Start'),
            DateTime::make('Availability End'),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }
}
