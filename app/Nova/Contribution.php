<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Contribution extends Resource
{
    public static $model = \App\Contribution::class;

    public static $title = 'title';

    public static $group = 'Dawn';

    public static $search = [
        'id', 'title',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Event'),
            Select::make('Type')->options([
                'sponsor' => 'Sponsorship Level',
                'vendor' => 'Vendor Table',
                'ad' => 'Advertisement',
            ])->sortable(),
            Text::make('Title')->sortable(),
            Text::make('Amount')
                ->displayUsing(function ($amount) {
                    return '$'.$amount / 100;
                })->sortable(),
            Trix::make('Description'),
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
