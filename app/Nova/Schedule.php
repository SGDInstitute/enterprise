<?php

namespace App\Nova;

use App\Nova\Actions\ExportSignUps;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Schedule extends Resource
{
    public static $model = \App\Schedule::class;

    public static $title = 'title';

    public static $group = 'Gemini';

    public function title()
    {
        return $this->event->title.' '.$this->title;
    }

    public static $search = [
        'id', 'title',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Event'),
            Text::make('Title'),

            HasMany::make('Activities'),
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
            new ExportSignUps,
        ];
    }
}
