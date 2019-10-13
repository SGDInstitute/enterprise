<?php

namespace App\Nova;

use App\Nova\Actions\DownloadResponses;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sgd\FormBuilder\FormBuilder;

class Form extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Form::class;

    public static $title = 'name';

    public static $search = [
        'id',
    ];

    public static $group = 'Voyager';

    public function fields(Request $request)
    {
        return [
            ID::make()->hideFromIndex(),
            Text::make('Name')->sortable(),
            Select::make('Type')->options([
                'survey' => 'Survey',
                'workshop' => 'Workshop'
            ]),
            Text::make('Slug')->hideFromIndex(),
            Text::make('List ID')->hideFromIndex(),
            BelongsTo::make('Event')->sortable(),
            DateTime::make('Start')->sortable()->format('DD MMM YYYY'),
            DateTime::make('End')->sortable()->format('DD MMM YYYY'),
            Boolean::make('Is Public')->sortable(),
            FormBuilder::make('Form')->hideFromIndex(),

            HasMany::make('Responses')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new DownloadResponses,
        ];
    }
}
