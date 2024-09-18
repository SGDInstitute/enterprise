<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventBulletin extends Model
{
    use HasFactory;

    public $guarded = [];

    // Relations

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    // Attributes

    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at->timezone($this->timezone)->format('D g:i a');
    }

    public function getIsPublishedAttribute()
    {
        return $this->published_at < now();
    }

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    // Methods
}
