<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Donation extends Model
{
    protected $guarded = [];

    /**
     * Boot function for using with User Events
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->hash = Hashids::connection('donations')->encode($model->id);
            $model->save();
        });
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }
}
