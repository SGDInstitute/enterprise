<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Receipt extends Resource
{
    public static $model = \App\Receipt::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static $displayInNavigation = false;

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Order'),
            BelongsTo::make('Donation'),
            Text::make('Transaction ID'),
            Currency::make('Amount')
                ->displayUsing(function ($amount) {
                    return money_format('$%.2n', $amount / 100);
                }),

            new Panel('Charge Details', $this->stripeDetails()),
        ];
    }

    private function stripeDetails()
    {
        if ($this->charge()) {
            return [
                Text::make('Card Number', function () {
                    return '****-****-****-' . $this->card_last_four;
                }),
                Text::make('Address', function () {
                    return $this->charge()['source']['address_line1'];
                }),
                Text::make('Address Line 2', function () {
                    return $this->charge()['source']['address_line2'];
                }),
                Text::make('City', function () {
                    return $this->charge()['source']['address_city'];
                }),
                Text::make('State', function () {
                    return $this->charge()['source']['address_state'];
                }),
                Text::make('Zip', function () {
                    return $this->charge()['source']['address_zip'];
                }),
            ];
        }
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
