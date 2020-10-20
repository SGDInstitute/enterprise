<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }
}
