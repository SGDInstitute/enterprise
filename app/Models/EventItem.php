<?php

namespace App\Models;

use App\Traits\HasSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class EventItem extends Model
{
    use HasFactory;
    use HasSettings;
    use HasSlug;
    use HasTags;

    public $guarded = [];

    protected $casts = [
        'end' => 'datetime',
        'settings' => 'array',
        'start' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // Relations

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    // Attributes

    public function getFormattedDurationAttribute()
    {
        if ($this->start->diffInHours($this->end) > 24) {
            return $this->start->timezone($this->timezone)->format('D, M j').' - '.$this->end->timezone($this->timezone)->format('D, M j, Y');
        } else {
            return $this->start->timezone($this->timezone)->format('D, M j Y g:i').' - '.$this->end->timezone($this->timezone)->format('g:i a');
        }
    }

    public function getShortNameAttribute()
    {
        return Str::limit($this->name, 30);
    }

    public function getShortDescriptionAttribute()
    {
        return Str::limit($this->description, 40);
    }

    public function getTracksAttribute()
    {
        return $this->tagsWithType('tracks')->pluck('name')->join(',');
    }

    // Methods
}
