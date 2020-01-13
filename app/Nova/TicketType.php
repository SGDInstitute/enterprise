<?php

namespace App\Nova;

use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class TicketType extends Resource
{

    public static $model = \App\TicketType::class;

    public static $title = 'name';

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
            Select::make('Type')->options(['regular' => 'Regular (Public)', 'discount' => 'Discount (Private)']),
            Text::make('Name')->sortable(),
            Textarea::make('Description')->sortable(),
            Number::make('Cost')
                ->displayUsing(function ($cost) {
                    return '$' . $cost / 100;
                })->help('Cost in cents. i.e. $20 would be 2000'),
            Number::make('Num Tickets')->help('Max number of tickets per order with this ticket type, leave empty for regular tickets.'),
            DateTime::make('Availability Start'),
            DateTime::make('Availability End'),

            BelongsToMany::make('Users')->searchable(),
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
