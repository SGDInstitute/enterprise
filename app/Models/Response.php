<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Response extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logAttributes = ['answers', 'status'];
    protected static $logOnlyDirty = true;

    public $guarded = [];

    protected $casts = [
        'answers' => 'collection',
    ];

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'collaborators');
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }


    // Attributes

    public function getNameAttribute()
    {
        return $this->answers['question-name'] ?? $this->answers['name'] ?? 'Indertiminable';
    }

    // Methods
}
