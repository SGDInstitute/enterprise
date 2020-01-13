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

    public function type()
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id');
    }
}
