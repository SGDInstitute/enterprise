<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $guarded = [];
    public $dates = ['reservation_ends', 'paid_at'];
    public $casts = ['invoice' => 'collection'];

    // Scopes

    public function scopeForEvent($query, $event)
    {
        return $query->where('event_id', $event->id);
    }

    public function scopeForUser($query, $user)
    {
        return $query->where('user_id', $user->id);
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Attributes

    public function getDatePaidAttribute()
    {
        if ($this->isPaid()) {
            return $this->paid_at->format('M d, Y');
        }

        return null;
    }

    public function getFormattedAmountAttribute()
    {
        if ($this->isPaid()) {
            return '$' . number_format($this->amount / 100, 2);
        }

        return $this->subtotal;
    }

    public function getFormattedConfirmationNumberAttribute()
    {
        if ($this->isPaid()) {
            return hyphenate($this->confirmation_number);
        }

        return 'n/a';
    }

    public function getFormattedIdAttribute()
    {
        return $this->event->order_prefix . $this->id;
    }

    public function getSubtotalAttribute()
    {
        $sum = $this->tickets->sum(function ($ticket) {
            return $ticket->price->cost;
        });

        return '$' . number_format($sum / 100, 2);
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

    public function isStripe()
    {
        return Str::startsWith($this->transaction_id, ['pi_', 'ch_']);
    }

    public function isPaid()
    {
        return $this->transaction_id !== null;
    }

    public function isReservation()
    {
        return $this->transaction_id === null;
    }

    public function markAsPaid($transactionId, $amount)
    {
        $this->transaction_id = $transactionId;
        $this->reservation_ends = null;
        $this->paid_at = now();
        $this->confirmation_number = substr(str_shuffle(str_repeat('ABCDEFGHJKLMNPQRSTUVWXYZ23456789', 20)), 0, 20);
        $this->amount = $amount;
        $this->save();
    }

    public function transactionDetails()
    {
        if ($this->isPaid()) {
            if (Str::startsWith($this->transaction_id, 'ch_')) {
                //
            } elseif (Str::startsWith($this->transaction_id, 'pi_')) {
                $stripe = new \Stripe\StripeClient('sk_test_fQdEhCWayI8KGossWGKsLhWo');
                dd($stripe->paymentIntents->retrieve($this->transaction_id, []));
            }
        }
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
