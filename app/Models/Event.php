<?php

namespace App\Models;

use App\Traits\HasSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Event extends Model implements HasMedia
{
    use HasFactory;
    use HasSettings;
    use InteractsWithMedia;
    use HasSlug;

    protected $guarded = [];

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

    public function bulletins(): HasMany
    {
        return $this->hasMany(EventBulletin::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(EventItem::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function paidOrders(): HasMany
    {
        return $this->hasMany(Order::class)->paid();
    }

    public function proposals(): HasManyThrough
    {
        return $this->hasManyThrough(Response::class, Form::class)->where('responses.type', 'workshop');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Order::class)->reservations();
    }

    public function publishedBulletins(): HasMany
    {
        return $this->hasMany(EventBulletin::class)->where('published_at', '<', now());
    }

    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class);
    }

    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }

    public function tickets(): HasManyThrough
    {
        return $this->hasManyThrough(Ticket::class, Order::class);
    }

    public function workshopForm(): HasOne
    {
        return $this->hasOne(Form::class)->where('type', 'workshop');
    }

    // Attributes

    public function getBackgroundUrlAttribute()
    {
        return $this->getFirstMediaUrl('background') ?? 'https://sgdinstitute.org/assets/headers/homepage-hero1.jpg';
    }

    public function getDaysUntilAttribute()
    {
        if ($this->end->isPast()) {
            return 0;
        }
        if ($this->hasStarted) {
            return $this->end->diffInDays(now());
        }

        return $this->start->diffInDays(now());
    }

    public function getFormattedDurationAttribute()
    {
        if ($this->start->diffInHours($this->end) > 24) {
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
        if ($this->settings->onsite && $this->location && $this->settings->livestream) {
            return $this->location . ' & Virtual';
        } elseif ($this->settings->onsite && $this->location !== '') {
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
        if ($this->timezone === 'America/New_York') {
            return 'EST';
        }
        if ($this->timezone === 'America/Chicago') {
            return 'CST';
        }
    }

    public function getReservationEndsAtAttribute()
    {
        $reservationEndsAt = now()->addDays($this->settings->reservation_length);
        if ($reservationEndsAt > $this->start) {
            return $this->start;
        }

        return $reservationEndsAt;
    }

    // Methods

    public function paidAttendees()
    {
        return $this->orders()->paid()->with('tickets.user')->get()
            ->flatMap->tickets
            ->filter(fn ($ticket) => $ticket->user_id !== null)
            ->map->user;
    }

    public function paidInPersonAttendees()
    {
        return $this->orders()->paid()->with('tickets.user')->get()
            ->flatMap->tickets
            ->filter(fn ($ticket) => ! Str::contains($ticket->ticketType->name, ['Virtual', 'virtual']))
            ->filter(fn ($ticket) => $ticket->user_id !== null)
            ->map->user;
    }
}
