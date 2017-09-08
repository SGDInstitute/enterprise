<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Ticket extends Model
{
    protected $fillable = ['ticket_type_id'];

    /**
     * Boot function for using with User Events
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model)
        {
            $model->hash = Hashids::encode($model->id);
            $model->save();
        });
    }

    public function ticket_type()
    {
        return $this->belongsTo(TicketType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeFilled($query)
    {
        return $query->whereNotNull('user_id');
    }

//    public function getHashAttribute()
//    {
//        return Hashids::encode($this->id);
//    }
}
