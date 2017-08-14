<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
