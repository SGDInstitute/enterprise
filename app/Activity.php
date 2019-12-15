<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    protected $dates = ['start', 'end'];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
