<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'description', 'location', 'slug', 'start', 'end', 'published_at'];

    protected $dates = ['start', 'end', 'published_at'];

    public static function findBySlug($slug)
    {
        return self::where('slug', $slug)->firstOrFail();
    }

    public function ticket_types()
    {
        return $this->hasMany(TicketType::class);
    }
}
