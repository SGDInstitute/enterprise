<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['plan', 'subscription_id', 'next_charge'];

    protected $casts = ['active' => 'boolean'];

    /**
     * Get the donation that owns the subscription.
     */
    public function donation()
    {
        return $this->belongsTo('App\Models\Sponsorship\Donation');
    }

    public function isActive()
    {
        return $this->active;
    }

    public function getFrequencyAttribute()
    {
        return ucfirst(substr($this->plan, 0, strpos($this->plan, '-')));
    }
}
