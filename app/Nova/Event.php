<?php

namespace App\Nova;

use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Timezone;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Panel;
use Sgd\Links\Links;

class Event extends Resource
{

    public static $model = \App\Event::class;

    public static $title = 'title';

    public static $search = [
        'title',
    ];

    public static $group = '';

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            TextWithSlug::make('Title')->slug('slug')->sortable(),
            Slug::make('Slug')->disableAutoUpdateWhenUpdating()->hideFromIndex(),
            Text::make('Subtitle')->hideFromIndex(),
            Trix::make('Description')->hideFromIndex(),
            Select::make('Stripe')->options(['institute' => 'institute', 'mblgtacc' => 'mblgtacc'])->sortable(),
            DateTime::make('Start')->sortable()->format('MMM DD, YYYY'),
            DateTime::make('End')->sortable()->format('MMM DD, YYYY'),
            Text::make('Ticket String')->hideFromIndex(),
            Links::make('Links')->hideFromIndex(),

            new Panel('Media', [
                File::make('Image')->disk('public'),
                File::make('Logo Light')->disk('public'),
                File::make('Logo Dark')->disk('public'),
            ]),

            new Panel('Place Information', [
                Text::make('Place')->hideFromIndex(),
                Text::make('Location')->hideFromIndex(),
                Timezone::make('Timezone')->hideFromIndex(),
            ]),

            new Panel('Policies', [
                Trix::make('Photo Policy')->hideFromIndex(),
                Trix::make('Refund Policy')->hideFromIndex(),
                Trix::make('Inclusion Policy')->hideFromIndex(),
            ]),

            HasMany::make('Ticket Types'),

            HasMany::make('Contributions'),

            HasMany::make('Orders'),
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
