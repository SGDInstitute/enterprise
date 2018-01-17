<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Stripe\Charge;

class Receipt extends Model
{
    use LogsActivity, SoftDeletes;

    protected $fillable = ['transaction_id', 'amount', 'card_last_four'];

    protected $dates = ['deleted_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function charge()
    {
        if ($this->order->isCard()) {
            return Charge::retrieve($this->transaction_id, [
                'api_key' => config($this->order->event->stripe . '.stripe.secret'),
            ]);
        }
    }
}
