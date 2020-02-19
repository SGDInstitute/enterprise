<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Timothyasp\Color\Color;

class ActivityType extends Resource
{
    public static $model = \App\ActivityType::class;

    public static $title = 'title';

    public static $group = 'Gemini';

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Title')->sortable(),
            Color::make('Color'),
            Color::make('Text Color')->help('Should have a good contrast value with the main color. Try #fff or #000'),
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
