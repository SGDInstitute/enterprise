<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Profile extends Model
{
    use LogsActivity;

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
