<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAmountAttribute()
    {
        return $this->tickets->map(function ($ticket) {
            return $ticket->ticket_type->cost;
        })->sum();
    }
}
