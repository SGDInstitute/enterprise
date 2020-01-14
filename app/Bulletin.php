<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    protected $casts = [
        'links' => 'arrray',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
