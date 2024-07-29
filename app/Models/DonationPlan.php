<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationPlan extends Model
{
    use HasFactory;

    public $guarded = [];

    // Relations
    public function prices(): HasMany
    {
        return $this->hasMany(DonationPrice::class, 'plan_id');
    }

    // Attributes

    // Methods
}
