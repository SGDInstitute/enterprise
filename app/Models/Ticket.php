<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function price()
    {
        return $this->belongsTo(Price::class);
    }

    public function queue()
    {
        return $this->hasOne(EventBadgeQueue::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Attributes

    // Methods

    public function addToQueue($user = null)
    {
        if ($user === null) {
            $this->queue()->create(['user_id' => $this->user->id, 'name' => $this->user->name, 'email' => $this->user->email, 'pronouns' => $this->user->pronouns]);
        } else {
            $this->queue()->create(['user_id' => $this->user->id, 'name' => $user->name, 'email' => $user->email, 'pronouns' => $user->pronouns]);
        }
    }

    public function isFilled()
    {
        return $this->user_id !== null;
    }

    public function isQueued()
    {
        return $this->queue !== null;
    }

    public function isPrinted()
    {
        return $this->isQueued() && $this->queue->printed;
    }
}
