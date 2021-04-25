<?php

namespace App\Models;

use App\Traits\HasSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes, HasSettings;

    public $guarded = [];
    public $dates = ['reservation_ends'];

    // Scopes

    public function scopeForEvent($query, $event)
    {
        return $query->where('event_id', $event->id);
    }

    public function scopeReservations($query)
    {
        return $query->whereNull('transaction_id');
    }

    public function scopePaid($query)
    {
        return $query->whereNotNull('transaction_id');
    }

    // Relations

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Attributes

    // Methods

    public function isPaid()
    {
        return $this->transaction_id !== null;
    }
}
