<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Donation extends Resource
{

    public static $model = \App\Donation::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static $searchRelations = [
        'user' => ['name', 'email']
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->hideFromIndex(),
            BelongsTo::make('User')->sortable(),
            Currency::make('Amount')
                ->displayUsing(function ($amount) {
                    return money_format('$%.2n', $amount / 100);
                })->sortable(),
            Text::make('Type', function () {
                if (!$this->contributions->isEmpty()) {
                    return 'Contribution: ' . $this->contributions->map(function ($contribution) {
                        if ($contribution->type === 'sponsor') {
                            return "{$contribution->title} ($" . $contribution->pivot->amount / 100 . ")";
                        } elseif ($contribution->pivot->quantity > 0) {
                            return "{$contribution->pivot->quantity} {$contribution->title}";
                        } else {
                            return "{$contribution->title}";
                        }
                    })->implode(', ');
                } else if (!$this->subscription !== null) {
                    return 'Recurring Donation';
                } else {
                    return 'One-time Donation';
                }
            }),
            Text::make('Group')->sortable(),
            Text::make('Name')->sortable(),
            Text::make('Email')->sortable(),
            Text::make('Company')->sortable(),
            Text::make('Tax ID')->sortable(),

            HasOne::make('Receipt'),
            HasOne::make('Subscription'),
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
