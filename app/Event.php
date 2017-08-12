<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'description', 'location', 'slug', 'start', 'end', 'published_at'];

    protected $dates = ['start', 'end', 'published_at'];

    protected $casts = [
        'links' => 'array',
    ];

    public static function findBySlug($slug)
    {
        return self::where('slug', $slug)->firstOrFail();
    }

    public function ticket_types()
    {
        return $this->hasMany(TicketType::class);
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
