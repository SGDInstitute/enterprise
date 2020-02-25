<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sgd\BulletinLinks\BulletinLinks;

class Bulletin extends Resource
{
    public static $model = \App\Bulletin::class;

    public static $group = 'Gemini';

    public static $title = 'id';

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Event'),
            Textarea::make('Content'),
            File::make('Image'),
            BulletinLinks::make('Links'),
            Boolean::make('Push Notification'),
            DateTime::make('Published At'),
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
