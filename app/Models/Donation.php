<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    public $guarded = [];

    public $casts = ['is_anonymous' => 'boolean', 'is_company' => 'boolean'];

    // Scopes

    public function scopeOneTime($query)
    {
        return $query->where('type', 'one-time');
    }

    public function scopeRecurring($query)
    {
        return $query->where('type', 'monthly');
    }

    // Relations

    // Attributes

    public function getFormattedAmountAttribute()
    {
        return '$' . number_format($this->amount/100, 2);
    }

    // Methods
}
