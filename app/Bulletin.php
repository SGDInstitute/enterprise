<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    protected $dates = ['published_at'];

    protected $casts = [
        'links' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
