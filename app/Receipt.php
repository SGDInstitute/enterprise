<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Receipt extends Model
{
    use LogsActivity;

    protected $fillable = ['transaction_id', 'amount', 'card_last_four'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
