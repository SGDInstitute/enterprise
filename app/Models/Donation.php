<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function getFormattedAmountAttribute()
    {
        return '$' . number_format($this->amount/100, 2);
    }

    public function getFormattedTypeAttribute()
    {
        return $this->type === 'monthly' ? 'Recurring Monthly' : 'One-Time';
    }

    // Methods

    public function cancel()
    {
        if($this->type === 'monthly') {
            Subscription::update($this->subscription_id, ['cancel_at_period_end' => true,]);
            $this->status = 'cancelled';
            $this->save();
        }
    }
}
