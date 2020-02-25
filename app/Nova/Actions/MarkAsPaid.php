<?php

namespace App\Nova\Actions;

use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class MarkAsPaid extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            if (is_a($model, Invoice::class)) {
                $order = $model->order;
            } else {
                $order = $model;
            }

            if ($fields->comped) {
                $order->markAsPaid(collect([
                    'id' => 'comped',
                    'amount' => 0,
                ]));
            } else {
                $order->markAsPaid(collect([
                    'id' => Str::start($fields->check_number, '#'),
                    'amount' => $fields->amount * 100,
                ]));
            }
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Check Number'),
            Number::make('Amount'),
            Boolean::make('Comped Order Instead', 'comped'),
        ];
    }
}
