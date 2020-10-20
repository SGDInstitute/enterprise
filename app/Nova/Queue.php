<?php

namespace App\Nova;

use App\Nova\Actions\PrintTicket;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Queue extends Resource
{
    public static $model = \App\Models\Queue::class;

    public static $title = 'id';

    public static $search = [
        'id',
        'batch',
        'name',
    ];

    public static $group = 'Genesis';

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Batch')->sortable(),
            Number::make('Ticket ID'),
            Text::make('Name')->sortable(),
            Text::make('Pronouns')->sortable(),
            Text::make('Tshirt')->sortable(),
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
            new PrintTicket,
        ];
    }
}
