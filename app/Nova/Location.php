<?php

namespace App\Nova;

use App\Imports\LocationsImport;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sgd\ImportCard\ImportCard;

class Location extends Resource
{
    public static $model = \App\Location::class;

    public static $title = 'title';

    public static $group = 'Gemini';

    public static $importer = LocationsImport::class;

    public static $search = [
        'title',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Event'),
            Text::make('Title'),
            Text::make('Abbreviation'),
            Text::make('Description'),
            Select::make('Type')->options(['conference' => 'Conference', 'hotel' => 'Hotel', 'entertainment' => 'Entertainment', 'food' => 'Food']),
            File::make('Background'),
            $this->addressFields(),

            HasMany::make('Floors'),
        ];
    }

    public function addressFields()
    {
        return $this->merge([
            Place::make('Address', 'address_line_1')->hideFromIndex()->countries(['US']),
            Text::make('Address Line 2')->hideFromIndex(),
            Text::make('City')->hideFromIndex(),
            Text::make('State')->hideFromIndex(),
            Text::make('Postal Code')->hideFromIndex(),
            Text::make('Latitude')->hideFromIndex(),
            Text::make('Longitude')->hideFromIndex(),
        ]);
    }

    public function cards(Request $request)
    {
        return [
            (new ImportCard(self::class))->withSample(url('documents/locations.xlsx')),
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
