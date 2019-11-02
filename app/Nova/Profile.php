<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Profile extends Resource
{

    public static $model = \App\Profile::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static $with = ['user'];

    public static $displayInNavigation = false;

    public function fields(Request $request)
    {
        return [
            BelongsTo::make('User'),
            Text::make('Pronouns'),
            Text::make('sexuality'),
            Text::make('gender'),
            Text::make('race'),
            Text::make('college'),
            Text::make('tshirt'),
            Text::make('accommodation'),
            Text::make('wants_program'),
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
