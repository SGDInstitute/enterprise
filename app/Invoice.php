<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoice extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'email', 'address', 'address_2', 'city', 'state', 'zip',];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
