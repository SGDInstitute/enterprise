<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public $guarded = [];
    public $dates = ['reservation_ends'];
    public $casts = ['invoice' => 'collection'];

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

    public function getFormattedIdAttribute()
    {
        return $this->event->order_prefix . $this->id;
    }

    public function getSubtotalAttribute()
    {
        $sum = $this->tickets->sum(function($ticket) {
            return $ticket->price->cost ?? $ticket->scaled_price;
        });

        return '$' . number_format($sum/100, 2);
    }

    // Methods

    public function generateInvoice()
    {
        $this->invoice = [
            'due_date' => $this->reservation_ends->format('m/d/Y'),
            'created_at' => now()->format('m/d/Y'),
            'billable' => auth()->user()->name . "\n" . auth()->user()->email,
        ];

        $this->save();
    }

    public function isFilled()
    {
        return $this->tickets->where('user_id', null)->count() > 0 ? false : true;
    }

    public function isPaid()
    {
        return $this->transaction_id !== null;
    }

    public function ticketsFormattedForCheckout()
    {
        return $this->tickets->groupBy('ticket_type_id')->mapWithKeys(function ($group) {
            return [$group->first()->price->stripe_price_id => $group->count()];
        })->toArray();
    }

    public function ticketsFormattedForInvoice()
    {
        return $this->tickets->groupBy('ticket_type_id')->map(function ($group) {
            $price = $group->first()->scaled_price ?? $group->first()->price->cost;
            return [
                'item' => $this->event->name . ' ' . $group->first()->ticketType->name . ' - ' . $group->first()->price->name,
                'quantity' => $group->count(),
                'price' => '$' . number_format($price / 100, 2),
                'total' => '$' . number_format($group->count() * $price / 100, 2),
            ];
        });
    }
}
