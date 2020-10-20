<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Stripe\Charge;

class Receipt extends Model
{
    use HasFactory;
    use LogsActivity, SoftDeletes;

    protected $fillable = ['transaction_id', 'amount', 'card_last_four'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function charge()
    {
        if (Str::startsWith($this->transaction_id, 'ch')) {
            $stripe = $this->order->event->stripe ?? $this->donation->group;

            return Charge::retrieve($this->transaction_id, [
                'api_key' => config($stripe.'.stripe.secret'),
            ]);
        }
    }

    public function subscription()
    {
        if (Str::startsWith($this->transaction_id, 'sub')) {
            $stripe = $this->order->event->stripe ?? $this->donation->group;

            return \Stripe\Subscription::retrieve($this->transaction_id, [
                'api_key' => config($stripe.'.stripe.secret'),
            ]);
        }
    }
}
