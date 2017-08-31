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

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function getAmountAttribute()
    {
        return $this->tickets->map(function ($ticket) {
            return $ticket->ticket_type->cost;
        })->sum();
    }

    public function scopeUpcoming($query)
    {
        return $query->join('events', 'orders.event_id', '=', 'events.id')
            ->whereDate('start', '>', Carbon::now());
    }

    public function scopePast($query)
    {
        return $query->join('events', 'orders.event_id', '=', 'events.id')
            ->whereDate('start', '<', Carbon::now());
    }

    public function markAsPaid($transactionId)
    {
        $this->transaction_id = $transactionId;
        $this->transaction_date = Carbon::now();
        $this->save();
    }

    public function markAsUnpaid()
    {
        $this->transaction_id = null;
        $this->transaction_date = null;
        $this->save();
    }

    public function isPaid()
    {
        return !is_null($this->transaction_id);
    }

    public function getTicketsWithNameAndAmount()
    {
        return $this->tickets->groupBy('ticket_type_id')->map(function($item) {
            return [
                'name' => $item[0]->ticket_type->name,
                'count' => $item->count(),
                'cost' => $item[0]->ticket_type->cost,
                'amount' => $item[0]->ticket_type->cost * $item->count()
            ];
        });
    }
}
