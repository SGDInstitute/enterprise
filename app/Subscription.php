<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['plan', 'subscription_id'];

    protected $casts = ['active' => 'boolean'];
}
