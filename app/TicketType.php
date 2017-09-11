<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TicketType extends Model
{
    use LogsActivity;

    protected $appends = ['formatted_cost', 'is_open'];

    public function getFormattedCostAttribute()
    {
        return "$" . number_format($this->cost / 100, 2);
    }

    public function getIsOpenAttribute()
    {
        if(is_null($this->availability_start) && is_null($this->availability_end)) {
            return true;
        }

        $now = Carbon::now();
        return $this->availability_start < $now && $now < $this->availability_end;
    }
}
