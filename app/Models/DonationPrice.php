<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonationPrice extends Model
{
    use HasFactory;

    public $guarded = [];

    // Relations
    public function plan(): BelongsTo
    {
        return $this->belongsTo(DonationPlan::class);
    }

    // Attributes

    public function getFormattedCostAttribute()
    {
        return '$' . number_format($this->cost / 100, 2) . ' / ' . $this->period;
    }

    // Methods
}
