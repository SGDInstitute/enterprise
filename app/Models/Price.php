<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'end' => 'datetime',
        'start' => 'datetime',
    ];

    // Relations

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }

    // Attributes

    public function getCostInDollarsAttribute()
    {
        return number_format($this->cost / 100, 2);
    }

    public function getFormattedCostAttribute()
    {
        return '$' . number_format($this->cost / 100);
    }

    public function getFormattedEndAttribute()
    {
        return $this->end?->timezone($this->timezone)->format('m/d/Y g:i A') ?? null;
    }

    public function getFormattedStartAttribute()
    {
        return $this->start?->timezone($this->timezone)->format('m/d/Y g:i A') ?? null;
    }

    public function getMaxInDollarsAttribute()
    {
        return number_format($this->max / 100, 2);
    }

    public function getMinInDollarsAttribute()
    {
        return number_format($this->min / 100, 2);
    }

    // Methods
}
