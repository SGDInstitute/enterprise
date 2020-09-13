<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class TicketType extends Model
{
    use HasFactory;
    use LogsActivity, SoftDeletes;

    protected $appends = ['formatted_cost', 'is_open'];

    protected $dates = [
        'availability_start', 'availability_end',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'discounts');
    }

    public function getFormattedCostAttribute()
    {
        return '$'.number_format($this->cost / 100, 2);
    }

    public function getIsOpenAttribute()
    {
        if (is_null($this->availability_start) && is_null($this->availability_end)) {
            return true;
        }

        $now = Carbon::now();

        return $this->availability_start < $now && $now < $this->availability_end;
    }
}
