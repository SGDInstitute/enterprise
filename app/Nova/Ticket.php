<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Ticket extends Resource
{
    public static $model = \App\Ticket::class;

    public static $title = 'id';

    public static $search = [
        'id',
        'hash',
    ];

    public static $searchRelations = [
        'user' => ['name', 'email'],
    ];

    public static $group = 'Registration';

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Hash')->sortable(),
            BelongsTo::make('User'),
            BelongsTo::make('Ticket Type'),
            BelongsTo::make('Order'),
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
