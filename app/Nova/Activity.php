<?php

namespace App\Nova;

use App\Imports\ActivitiesImport;
use App\Nova\Filters\ActivityType;
use App\Nova\Filters\Schedule;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Sgd\ImportCard\ImportCard;

class Activity extends Resource
{
    public static $model = 'App\Activity';

    public static $title = 'title';

    public static $group = 'Gemini';

    public static $search = [
        'id', 'title', 'description'
    ];

    public static $importer = ActivitiesImport::class;

    public static $searchRelations = [
        'schedule' => ['title'],
        'schedule.event' => ['title'],
        'activity_type' => ['title'],
        'location' => ['title'],
        'room' => ['number']
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Schedule'),
            BelongsTo::make('Activity Type')->sortable(),
            BelongsTo::make('Response')->hideFromIndex()->nullable(),
            BelongsTo::make('Location')->sortable()->nullable(),
            BelongsTo::make('Room')->sortable()->nullable(),
            Text::make('Title')->sortable(),
            Trix::make('Description'),
            DateTime::make('Start')->sortable(),
            DateTime::make('End')->sortable(),
            Number::make('Spots')->sortable(),

            BelongsToMany::make('Speakers', 'speakers', 'App\Nova\User')->searchable(),
        ];
    }

    public function cards(Request $request)
    {
        return [
            (new ImportCard(Activity::class))->withSample(url('documents/schedule.xlsx')),
        ];
    }

    public function filters(Request $request)
    {
        return [
            new Schedule,
            new ActivityType,
        ];
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
