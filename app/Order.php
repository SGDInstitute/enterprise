<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id'];

    protected $appends = ['amount'];

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

    public function markAsPaid($transactionId)
    {
        $this->transaction_id = $transactionId;
        $this->transaction_date = Carbon::now();
        $this->save();
    }

    public function isPaid()
    {
        return !is_null($this->transaction_id);
    }
}
