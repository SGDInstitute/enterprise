<?php

namespace App\Nova;

use App\Nova\Actions\DownloadResponses;
use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sgd\FormBuilder\FormBuilder;

class Form extends Resource
{
    public static $model = \App\Form::class;

    public static $title = 'name';

    public static $search = [
        'id',
    ];

    public static $searchRelations = [
        'event' => ['title'],
    ];

    public static $group = 'Voyager';

    public function fields(Request $request)
    {
        return [
            ID::make()->hideFromIndex(),
            TextWithSlug::make('Name')
                ->slug('slug')->sortable(),
            Slug::make('Slug')
                ->disableAutoUpdateWhenUpdating()->hideFromIndex(),
            Select::make('Type')->options([
                'survey' => 'Survey',
                'evaluation' => 'Evaluation (Gemini)',
                'workshop' => 'Workshop',
                'volunteer' => 'Volunteer',
                'default' => 'Default',
            ]),
            Boolean::make('Auth Required'),
            Text::make('List ID')->hideFromIndex(),
            BelongsTo::make('Event')->sortable(),
            DateTime::make('Start')->sortable()->format('DD MMM YYYY'),
            DateTime::make('End')->sortable()->format('DD MMM YYYY'),
            Boolean::make('Is Public')->sortable(),
            FormBuilder::make('Form')->hideFromIndex(),

            HasMany::make('Responses'),
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
            new DownloadResponses,
        ];
    }
}
