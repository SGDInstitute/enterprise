<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Tags\HasTags;

class Thread extends Model
{
    use HasFactory;
    use HasTags;

    protected $guarded = [];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForEvent(Builder $query, Event $event): void
    {
        $query->where('event_id', $event->id);
    }
    
    public function getIsApprovedAttribute()
    {
        return $this->approved_at !== null;
    }
}
