<?php

namespace App\Nova;

use App\Nova\Actions\ImportActivities;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Activity extends Resource
{

    public static $model = 'App\Activity';

    public static $title = 'title';

    public static $search = [
        'id', 'title'
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Schedule'),
            Text::make('Title'),
            Trix::make('Description'),
            DateTime::make('Start')->sortable()->format('MMM DD, YYYY'),
            DateTime::make('End')->sortable()->format('MMM DD, YYYY'),
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
            new ImportActivities,
        ];
    }
}
