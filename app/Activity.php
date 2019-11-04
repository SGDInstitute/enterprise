<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
