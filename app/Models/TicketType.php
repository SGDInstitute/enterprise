<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    use HasFactory;

    public $guarded = [];
    public $dates = ['start', 'end'];

    // Relationships

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Attributes

    public function getAvailablityAttribute()
    {
        if($this->start && $this->end) {
            return 'Available: ' . $this->start->timezone($this->timezone)->format('M j') . ' - ' . $this->end->timezone($this->timezone)->format('M j, Y');
        }
    }

    public function getCostInDollarsAttribute()
    {
        return number_format($this->cost/100, 2);
    }

    public function getFormattedCostAttribute()
    {
        return '$' . number_format($this->cost/100, 2);
    }

    public function getFormattedEndAttribute()
    {
        return optional($this->end)->timezone($this->event->timezone)->format('m/d/Y g:i A') ?? null;
    }

    public function getFormattedStartAttribute()
    {
        return optional($this->start)->timezone($this->event->timezone)->format('m/d/Y g:i A') ?? null;
    }

    // Methods
}
