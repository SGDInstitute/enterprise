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
        'accessibility',
        'other_accessibility',
        'language',
        'other_language',
        'agreement',
    ];

    protected $casts = [
        'accessibility' => 'array',
        'language' => 'array',
        'wants_program' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
