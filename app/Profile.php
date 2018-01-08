<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Profile extends Model
{
    use LogsActivity, SoftDeletes;

    protected $fillable = [
        'pronouns',
        'sexuality',
        'gender',
        'race',
        'college',
        'tshirt',
        'accommodation',
        'wants_program',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = ['wants_program' => 'boolean'];
}
