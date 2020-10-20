<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Profile extends Model
{
    use HasFactory;
    use LogsActivity, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'accessibility' => 'array',
        'language' => 'array',
        'wants_program' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getJoinedAccessabilityAttribute()
    {
        return array_merge((array) $this->accessability, (array) $this->other_accessability);
    }

    public function getJoinedLanguageAttribute()
    {
        return array_merge((array) $this->language, (array) $this->other_language);
    }
}
