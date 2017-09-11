<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'pronouns',
        'sexuality',
        'gender',
        'race',
        'college',
        'tshirt',
        'accommodation',
    ];
}
