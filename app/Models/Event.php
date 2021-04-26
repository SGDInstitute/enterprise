<?php

namespace App\Models;

use App\Traits\HasSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Event extends Model implements HasMedia
{
    use HasFactory, HasSettings, InteractsWithMedia, HasSlug;

    protected $guarded = [];

    public $casts = ['settings' => 'array'];
    public $dates = ['start', 'end'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getBackgroundUrlAttribute()
    {
        return $this->getFirstMediaUrl('background') ?? 'https://sgdinstitute.org/assets/headers/homepage-hero1.jpg';
    }

    public function getFormattedDurationAttribute()
    {
        if($this->start->diffInHours($this->end) > 24) {
            return $this->start->timezone($this->timezone)->format('D, M j') . ' - ' . $this->end->timezone($this->timezone)->format('D, M j, Y');
        } else {
            return $this->start->timezone($this->timezone)->format('D, M j Y g:i a') . ' - ' . $this->end->timezone($this->timezone)->format('g:i a');
        }
    }

    public function getFormattedEndAttribute()
    {
        return $this->end->timezone($this->timezone)->format('m/d/Y g:i A');
    }

    public function getFormattedLocationAttribute()
    {
        if($this->settings->onsite && $this->settings->livestream) {
            return $this->location . ' & Virtual';
        } elseif($this->settings->onsite) {
            return $this->location;
        } else {
            return 'Virtual';
        }
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

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }

    public function workshopForm()
    {
        return $this->hasOne(Form::class)->where('type', 'workshop')->where('event_id', $this->id);
    }
}
