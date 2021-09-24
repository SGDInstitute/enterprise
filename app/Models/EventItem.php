<?php

namespace App\Models;

use App\Traits\HasSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;

class EventItem extends Model
{
    use HasFactory, HasSettings, HasTags;

    public $guarded = [];

    public $casts = ['settings' => 'array'];
    public $dates = ['start', 'end'];

    // Relations

    public function track()
    {
        return $this->belongsTo(EventTrack::class, 'track_id');
    }

    // Attributes

    // Methods
}
