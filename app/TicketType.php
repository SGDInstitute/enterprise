<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    public function getFormattedCostAttribute()
    {
        return "$" . number_format($this->cost/100, 2);
    }
}
