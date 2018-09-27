<?php

namespace App\Nova;

use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Timezone;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Event extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Event';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Title')->sortable(),
            Text::make('Slug')->hideFromIndex(),
            Text::make('Subtitle')->hideFromIndex(),
            Trix::make('Description')->hideFromIndex(),
            Select::make('Stripe')->options(['institute' => 'institute', 'mblgtacc' => 'mblgtacc'])->sortable(),
            DateTime::make('Start')->sortable()->format('MMM DD, YYYY'),
            DateTime::make('End')->sortable()->format('MMM DD, YYYY'),
            Text::make('Ticket String')->hideFromIndex(),
            Code::make('Links')->json(),

            new Panel('Place Information', [
                Text::make('Place')->hideFromIndex(),
                Text::make('Location')->hideFromIndex(),
                Timezone::make('Timezone')->hideFromIndex(),
            ]),

            new Panel('Policies', [
                Trix::make('Photo Policy')->hideFromIndex(),
                Trix::make('Refund Policy')->hideFromIndex(),
            ]),

            HasMany::make('Ticket Types')
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
        return [];
    }
}
