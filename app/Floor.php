<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
