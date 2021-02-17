<?php

namespace App\Models;

use App\Traits\HasSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use HasFactory, HasSettings, InteractsWithMedia;

    protected $guarded = [];

    public $casts = ['settings' => 'array'];
    public $dates = ['start', 'end'];

    public function getFormattedEndAttribute()
    {
        return $this->end->timezone($this->timezone)->format('m/d/Y g:i A');
    }

    public function getFormattedStartAttribute()
    {
        return $this->start->timezone($this->timezone)->format('m/d/Y g:i A');
    }

    public function getFormattedTimezoneAttribute()
    {
        if($this->timezone === 'America/New_York') {
            return 'EST';
        }
        if($this->timezone === 'America/Chicago') {
            return 'CST';
        }
    }
}
