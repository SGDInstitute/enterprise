<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Stripe\PaymentMethod;
use Stripe\Subscription;

class Donation extends Model
{
    use HasFactory;

    public $guarded = [];

    public $casts = ['is_anonymous' => 'boolean', 'is_company' => 'boolean'];

    // Scopes

    public function scopeForUser($query, $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeOneTime($query)
    {
        return $query->where('type', 'one-time');
    }

    public function scopeRecurring($query)
    {
        return $query->where('type', 'monthly');
    }

    // Relations

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Attributes

    public function getCardAttribute()
    {
        if ($this->stripe_subscription->default_payment_method) {
            return PaymentMethod::retrieve($this->stripe_subscription->default_payment_method)->card;
        }
    }

    public function getLastBillDateAttribute()
    {
        return Carbon::parse($this->stripe_subscription->current_period_start)->format('F j, Y');
    }

    public function getNextBillDateAttribute()
    {
        return Carbon::parse($this->stripe_subscription->current_period_end)->format('F j, Y');
    }

    public function getStripeSubscriptionAttribute()
    {
        if (Str::startsWith($this->subscription_id, 'test_')) {
            return (object) [
                'id' => $this->subscription_id,
                'current_period_end' => now()->addDays(15)->timestamp,
            ];
        }

        return Subscription::retrieve($this->subscription_id);
    }

    public function getFormattedAmountAttribute()
    {
        return '$'.number_format($this->amount / 100, 2);
    }

    public function getFormattedTypeAttribute()
    {
        return $this->type === 'monthly' ? 'Recurring Monthly' : 'One-Time';
    }

    // Methods

    public function cancel()
    {
        if ($this->type === 'monthly') {
            Subscription::update($this->subscription_id, ['cancel_at_period_end' => true]);
            $this->status = 'canceled';
            $this->save();
        }
    }
}
