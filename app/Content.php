<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'content';

    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
