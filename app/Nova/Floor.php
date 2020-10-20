<?php

namespace App\Nova;

use App\Imports\FloorsImport;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Sgd\ImportCard\ImportCard;

class Floor extends Resource
{
    public static $model = \App\Models\Floor::class;

    public function title()
    {
        if ($this->title) {
            return $this->location->title.' '.$this->title;
        }

        return $this->location->title.' Floor '.$this->level;
    }

    public static $group = 'Gemini';

    public static $importer = FloorsImport::class;

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Location'),
            Text::make('Title'),
            Text::make('Level'),
            File::make('Floor Plan'),

            HasMany::make('Rooms'),
        ];
    }

    public function cards(Request $request)
    {
        return [
            (new ImportCard(self::class))->withSample(url('documents/floors.xlsx')),
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
