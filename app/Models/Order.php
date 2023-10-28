<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\SchemalessAttributes\SchemalessAttributes;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $guarded = [];

    protected $casts = [
        'invoice' => 'collection',
        'reservation_ends' => 'datetime',
        'paid_at' => 'datetime',
    ];

    // Scopes

    public function scopeForEvent($query, $event)
    {
        return $query->where('event_id', $event->id);
    }

    public function scopeForUser($query, $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeWithInvoice(): Builder
    {
        return SchemalessAttributes::scopeWithSchemalessAttributes('invoice');
    }

    public function scopeReservations($query)
    {
        return $query->whereNull('paid_at')
            ->orWhereNull('transaction_id');
    }

    public function scopePaid($query)
    {
        return $query->whereNotNull('paid_at');
    }

    // Relations

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'order_id');
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

    public function getFormattedAddressAttribute()
    {
        if (is_array($this->invoice['address'])) {
            $address = $this->invoice['address'];

            return isset($address['line2'])
                ? "{$address['line1']} {$address['line2']}, {$address['city']}, {$address['state']}, {$address['zip']}"
                : "{$address['line1']}, {$address['city']}, {$address['state']}, {$address['zip']}";
        }
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

    public function getFormattedReservationEndsAttribute()
    {
        if ($this->isReservation()) {
            return $this->reservation_ends->format('M d, Y');
        }
    }

    public function getInvoiceAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'invoice');
    }

    public function getSubtotalAttribute()
    {
        return '$' . number_format($this->subtotalInCents / 100, 2);
    }

    public function getSubtotalInCentsAttribute()
    {
        return $this->tickets->sum(function ($ticket) {
            return $ticket->price->cost;
        });
    }

    // Methods

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
        return $this->paid_at !== null;
    }

    public function isReservation()
    {
        return $this->status === 'reservation' || $this->transaction_id === null;
    }

    public function markAsPaid($transactionId, $amount)
    {
        $this->transaction_id = $transactionId;
        $this->reservation_ends = null;
        $this->paid_at = now();
        $this->confirmation_number = substr(str_shuffle(str_repeat('ABCDEFGHJKLMNPQRSTUVWXYZ23456789', 20)), 0, 20);
        $this->amount = $amount;
        $this->status = 'succeeded';
        $this->save();
    }

    public function markAsUnpaid()
    {
        $this->update([
            'transaction_id' => null,
            'reservation_ends' => $this->event->reservationEndsAt,
            'paid_at' => null,
            'confirmation_number' => null,
            'amount' => null,
            'status' => 'reservation',
        ]);
    }

    public function safeDelete()
    {
        $this->tickets->each->delete();
        $this->delete();
    }

    public function transactionDetails()
    {
        if ($this->isPaid()) {
            if (Str::startsWith($this->transaction_id, 'ch_')) {
                //
            } elseif (Str::startsWith($this->transaction_id, 'pi_')) {
                $paymentIntent = PaymentIntent::retrieve($this->transaction_id);
                $method = PaymentMethod::retrieve($paymentIntent->payment_method);

                if ($method->type === 'card') {
                    return [
                        'type' => 'card',
                        'brand' => $method->card->brand,
                        'last4' => $method->card->last4,
                        'exp' => $method->card->exp_month . '/' . $method->card->exp_year,
                    ];
                }
            } elseif (Str::startsWith($this->transaction_id, '#') || is_numeric($this->transaction_id)) {
                return [
                    'type' => 'check',
                    'check_number' => Str::start($this->transaction_id, '#'),
                ];
            } elseif (Str::startsWith($this->transaction_id, 'comped')) {
                return [
                    'type' => 'comped',
                    'description' => $this->transaction_id,
                ];
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
