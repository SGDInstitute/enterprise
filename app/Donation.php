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

    public static function createOneTime($data, $charge)
    {
        $donation = self::create([
            'amount' => $data['amount'] * 100,
            'user_id' => request()->user() ? request()->user()->id : null,
            'name' => $data['name'],
            'email' => $data['email'],
            'company' => array_get($data, 'company'),
            'tax_id' => array_get($data, 'tax_id'),
        ]);

        $donation->receipt()->create([
            'transaction_id' => $charge->get('id'),
            'amount' => $charge->get('amount'),
            'card_last_four' => $charge->get('last4'),
        ]);

        return $donation;
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }
}
