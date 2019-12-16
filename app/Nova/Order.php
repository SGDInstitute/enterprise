<?php

namespace App\Nova;

use App\Nova\Actions\DownloadOrders;
use App\Nova\Actions\MarkAsPaid;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class Order extends Resource
{

    public static $model = \App\Order::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static $searchRelations = [
        'event' => ['title'],
        'user' => ['name', 'email']
    ];

    public static $with = ['tickets'];

    public static $group = 'Registration';

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable()->hideFromIndex(),
            BelongsTo::make('Event'),
            BelongsTo::make('User'),
            HasOne::make('Invoice'),
            HasOne::make('Receipt'),

            Currency::make('Amount')
                ->displayUsing(function ($amount) {
                    return money_format('$%.2n', $amount / 100);
                }),
            Number::make('Tickets', function () {
                return $this->tickets->count();
            })->onlyOnIndex(),
            Text::make('Completed', function () {
                return $this->tickets()->completed()->count() / $this->tickets->count() * 100 . '% (' . $this->tickets()->completed()->count() . ')';
            })->onlyOnIndex(),
            HasMany::make('Tickets'),

            Boolean::make('Is Paid', function () {
                return $this->isPaid();
            }),
            Text::make('Confirmation Number')->hideFromIndex(),

            Date::make('Created At')->sortable(),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [
            new Filters\Event,
            new Filters\IsPaid,
        ];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [
            new MarkAsPaid,
            new DownloadOrders,
        ];
    }
}
