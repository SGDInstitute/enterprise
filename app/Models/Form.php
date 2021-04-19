<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Form extends Model
{
    use HasFactory, HasSlug;

    public $guarded = [];

    protected $casts = [
        'auth_required' => 'boolean',
        'form' => 'collection',
    ];
    public $dates = ['start', 'end'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getFormattedEndAttribute()
    {
        if($this->timezone === null || $this->end === null) {
            return now()->format('m/d/Y g:i A');
        }

        return $this->end->timezone($this->timezone)->format('m/d/Y g:i A');
    }

    public function getFormattedStartAttribute()
    {
        if($this->timezone === null || $this->start === null) {
            return now()->format('m/d/Y g:i A');
        }

        return $this->start->timezone($this->timezone)->format('m/d/Y g:i A');
    }

    public function getHasCollaboratorsAttribute()
    {
        return $this->form->contains('style', 'collaborators');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
