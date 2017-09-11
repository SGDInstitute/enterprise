<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Receipt extends Model
{
    use LogsActivity, SoftDeletes;

    protected $fillable = ['transaction_id', 'amount', 'card_last_four'];

    protected $dates = ['deleted_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
