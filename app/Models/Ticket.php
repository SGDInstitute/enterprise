<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    public $guarded = [];

    protected $casts = [
        'answers' => 'collection',
    ];

    // Scopes

    public function scopeFilled($query)
    {
        return $query->whereNotNull('user_id');
    }

    // Relations

    public function price()
    {
        return $this->belongsTo(Price::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Attributes

    // Methods

    public function isFilled()
    {
        return $this->user_id !== null;
    }
}
