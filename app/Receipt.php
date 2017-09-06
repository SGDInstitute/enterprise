<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = ['transaction_id', 'amount', 'card_last_four'];
}
