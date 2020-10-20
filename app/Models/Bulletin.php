<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    use HasFactory;

    protected $dates = ['published_at'];

    protected $casts = [
        'links' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
