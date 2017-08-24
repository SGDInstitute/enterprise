<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['address', 'address_2', 'city', 'state', 'zip',];
}
