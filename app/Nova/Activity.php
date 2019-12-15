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
use Sgd\ActivitityUpload\ActivitityUpload;

class Activity extends Resource
{

    public static $model = 'App\Activity';

    public static $title = 'title';

    public static $group = 'Gemini';

    public static $search = [
        'id', 'title'
    ];

    public static $searchRelations = [
        'schedule' => ['title'],
        'schedule.event' => ['title'],
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Schedule'),
            Text::make('Title'),
            Trix::make('Description'),
            DateTime::make('Start')->sortable(),
            DateTime::make('End')->sortable(),
        ];
    }

    public function cards(Request $request)
    {
        return [
            new ActivitityUpload
        ];
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
