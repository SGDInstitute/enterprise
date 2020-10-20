<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sgd\FormResponse\FormResponse;

class Response extends Resource
{
    public static $model = \App\Models\Response::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static $searchRelations = [
        'form' => ['name'],
        'user' => ['name', 'email'],
    ];

    public static $group = 'Voyager';

    public static $with = ['form'];

    public function fields(Request $request)
    {
        $form = optional($this->form)->toArray();

        return [
            ID::make()->sortable(),
            BelongsTo::make('Form'),
            BelongsTo::make('User'),
            Text::make('Email')->sortable(),
            FormResponse::make('Responses')->hideFromIndex()->form($form),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [
            new Filters\Form,
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
