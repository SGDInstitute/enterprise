<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoice extends Model
{
    use HasFactory;

    use LogsActivity, SoftDeletes;

    protected $fillable = ['name', 'email', 'address', 'address_2', 'city', 'state', 'zip'];

    protected $dates = [
        'due_date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getDueDateAttribute()
    {
        if (is_null($this->order)) {
            return $this->created_at->addDays(60);
        }
        if ($this->created_at->addDays(60) < $this->order->event->start) {
            return $this->created_at->addDays(60);
        } else {
            return $this->order->event->start;
        }
    }
}
