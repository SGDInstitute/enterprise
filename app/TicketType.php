<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    public function getFormattedCostAttribute()
    {
        return "$" . number_format($this->cost / 100, 2);
    }

    public function getIsOpenAttribute()
    {
        $now = Carbon::now();
        return $this->availability_start < $now && $now < $this->availability_end;
    }
}
