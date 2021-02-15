<?php

namespace App\Models;

use App\Traits\HasSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasFactory, HasSettings;

    protected $guarded = [];

    public $appends = ['formattedEnd', 'formattedStart'];
    public $casts = ['settings' => 'array'];
    public $dates = ['start', 'end'];

    public function getFormattedEndAttribute()
    {
        return $this->end->timezone($this->timezone)->format('m/d/Y h:i A');
    }

    public function getFormattedStartAttribute()
    {
        return $this->start->timezone($this->timezone)->format('m/d/Y h:i A');
    }

    public function setFormattedEndAttribute($value)
    {
        $this->attributes['end'] = Carbon::parse($value, $this->timezone)->timezone('UTC');
    }

    public function setFormattedStartAttribute($value)
    {
        $this->attributes['start'] = Carbon::parse($value, $this->timezone)->timezone('UTC');
    }
}
