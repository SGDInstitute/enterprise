<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = ['name', 'pronouns', 'tshirt', 'order_created', 'order_paid'];
}
