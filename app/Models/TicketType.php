<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'end' => 'datetime',
        'form' => 'collection',
        'end' => 'datetime',
    ];

    // Relationships

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    // Attributes

    public function getAvailablityAttribute()
    {
        if ($this->start && $this->end) {
            return 'Available: ' . $this->start->timezone($this->timezone)->format('M j') . ' - ' . $this->end->timezone($this->timezone)->format('M j, Y');
        }
    }

    public function getFormattedEndAttribute()
    {
        return optional($this->end)->timezone($this->timezone)->format('m/d/Y g:i A') ?? null;
    }

    public function getFormattedStartAttribute()
    {
        return $this->start->timezone($this->timezone)->format('m/d/Y g:i A') ?? null;
    }

    public function getPriceRangeAttribute()
    {
        return '$' . $this->prices->min('cost') / 100 . ' - $' . $this->prices->max('cost') / 100;
    }

    // Methods

    public function safeDelete()
    {
        $this->prices->each(fn($price) => $price->delete());
        $this->delete();
    }
}
