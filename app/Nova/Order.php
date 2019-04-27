<?php

namespace App\Nova;

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
use Laravel\Nova\Http\Requests\NovaRequest;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Order';

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

    public static $with = ['tickets'];

    public static $group = 'Registration';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
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
                return $this->tickets()->completed()->count()/$this->tickets->count()*100 . '% (' . $this->tickets()->completed()->count() . ')';
            })->onlyOnIndex(),
            HasMany::make('Tickets'),

            Boolean::make('Is Paid', function () {
                return $this->isPaid();
            }),
            Text::make('Confirmation Number')->hideFromIndex(),

            Date::make('Created At')->sortable(),
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
        return [
            new Filters\Event,
            new Filters\IsPaid,
        ];
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
            new MarkAsPaid,
        ];
    }
}
