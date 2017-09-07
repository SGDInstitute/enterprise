<?php

namespace App;

use Facades\App\ConfirmationNumber;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id'];

    protected $dates = ['transaction_date'];

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

    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }

    public function getAmountAttribute()
    {
        if($this->isPaid()) {
            return $this->receipt->amount;
        }

        return $this->tickets->map(function ($ticket) {
            return $ticket->ticket_type->cost;
        })->sum();
    }

    public function scopeUpcoming($query)
    {
        return $query->select('orders.*', 'events.start')
            ->join('events', 'orders.event_id', '=', 'events.id')
            ->whereDate('start', '>', Carbon::now());
    }

    public function scopePast($query)
    {
        return $query
            ->select('orders.*', 'events.start')
            ->join('events', 'orders.event_id', '=', 'events.id')
            ->whereDate('start', '<', Carbon::now());
    }

    public function markAsPaid($charge)
    {
        $this->receipt()->create([
            'transaction_id' => $charge->get('id'),
            'amount' => $charge->get('amount'),
            'card_last_four' => $charge->get('last4'),
        ]);

        $this->confirmation_number = ConfirmationNumber::generate();
        $this->save();
    }

    public function markAsUnpaid()
    {
        $this->receipt->delete();
        $this->confirmation_number = null;
        $this->save();
    }

    public function isPaid()
    {
        return !is_null($this->receipt);
    }

    public function isCheck()
    {
        return starts_with($this->receipt->transaction_id, '#');
    }

    public function isCard()
    {
        return starts_with($this->receipt->transaction_id, 'ch');
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
