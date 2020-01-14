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

    public function toArray()
    {
        return [
            'id' => $this->id,
            'schedule' => $this->schedule,
            'title' => $this->title,
            'speaker' => $this->speaker,
            'description' => $this->description,
            'type' => $this->type->title,
            'color' => $this->type->color,
            'location' => $this->location,
            'start' => $this->start->tz($this->timezone)->format('Y-m-d H:i'),
            'start_time' => $this->start->tz($this->timezone)->format('g:i a'),
            'end' => $this->end->tz($this->timezone)->format('Y-m-d H:i'),
            'end_time' => $this->end->tz($this->timezone)->format('g:i a'),
        ];
    }
}
