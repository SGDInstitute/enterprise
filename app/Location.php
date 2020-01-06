<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }
}
