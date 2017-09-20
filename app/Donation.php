<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $guarded = [];

    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }
}
