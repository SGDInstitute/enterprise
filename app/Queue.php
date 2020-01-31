<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = ['batch', 'ticket_id', 'name', 'pronouns', 'tshirt', 'college', 'order_created', 'order_paid', 'completed'];

    protected $casts = [
        'completed' => 'boolean',
    ];

    public static function complete($ids)
    {
        self::whereIn('id', $ids)->update(['completed' => 1]);
    }
}
