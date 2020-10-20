<?php

namespace App\Nova;

use App\Nova\Actions\MarkAsPaid;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Invoice extends Resource
{
    public static $model = \App\Models\Invoice::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static $searchRelations = [
        'order' => ['id'],
    ];

    public static $group = 'Registration';

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Invoice #', function () {
                return '#'.str_pad($this->id, 6, '0', STR_PAD_LEFT);
            }),
            BelongsTo::make('Order'),
            Boolean::make('Is Paid', function () {
                return optional($this->order)->isPaid();
            }),
            Text::make('Name'),
            Text::make('Email'),
            Text::make('Address')->hideFromIndex(),
            Text::make('Address 2')->hideFromIndex(),
            Text::make('City')->hideFromIndex(),
            Text::make('State')->hideFromIndex(),
            Text::make('Zip')->hideFromIndex(),
            Date::make('Due Date'),

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
        return [
            new MarkAsPaid,
        ];
    }
}
