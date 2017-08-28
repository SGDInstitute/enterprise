<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['name', 'email', 'address', 'address_2', 'city', 'state', 'zip',];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
