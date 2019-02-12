<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = ['ticket_id', 'name', 'pronouns', 'tshirt', 'order_created', 'order_paid'];
}
