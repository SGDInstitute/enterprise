<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Floor extends Resource
{
    public static $model = 'App\Floor';

    public static $title = 'id';

    public static $group = 'Gemini';

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Location'),
            Text::make('Title'),
            Text::make('Level'),
            File::make('Floor Plan'),

            HasMany::make('Rooms'),
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
