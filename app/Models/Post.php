<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Tags\HasTags;

class Post extends Model
{
    use HasFactory, HasTags;

    protected $guarded = [];

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved(Builder $query): void
    {
        $query->whereNotNull('approved_at')->whereNotNull('approved_by');
    }

    public function scopeForEvent(Builder $query, Event $event): void
    {
        $query->where('event_id', $event->id);
    }

    public function scopeUnapproved(Builder $query): void
    {
        $query->whereNull('approved_at')->whereNull('approved_by');
    }

    public function getIsApprovedAttribute()
    {
        return $this->approved_at !== null;
    }

    public function approve($user)
    {
        $this->update([
            'approved_by' => $user->id,
            'approved_at' => now(),
        ]);
    }
}
