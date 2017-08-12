<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    protected $fillable = ['name', 'description', 'location', 'slug', 'start', 'end', 'published_at'];

    protected $dates = ['start', 'end', 'published_at'];

    protected $casts = [
        'links' => 'array',
    ];

    public function ticket_types()
    {
        return $this->hasMany(TicketType::class);
    }

    public function scopeFindBySlug($query, $slug)
    {
        return $query->where('slug', $slug)->firstOrFail();
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->whereDate('published_at', '<', Carbon::now());
    }

    public function getFormattedStartAttribute()
    {
        return $this->start->timezone($this->timezone)->format('D, M j');
    }

    public function getFormattedEndAttribute()
    {
        return $this->end->timezone($this->timezone)->format('D, M j');
    }

    public function getDurationAttribute()
    {
        return $this->start->timezone($this->timezone)->format('l F j, Y g:i A')
            . " to " . $this->end->timezone($this->timezone)->format('l F j, Y g:i A T');
    }
}
