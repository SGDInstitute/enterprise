<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Response extends Model
{
    use HasFactory;
    use LogsActivity;

    public $guarded = [];

    protected $casts = [
        'answers' => 'collection',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['answers', 'status'])
            ->logOnlyDirty();
    }

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Attributes

    public function getNameAttribute()
    {
        if (isset($this->answers['question-name']) && $this->answers['question-name'] === '') {
            return 'Not answered';
        }
        return $this->answers['question-name'] ?? $this->answers['name'] ?? 'Indertiminable';
    }

    // Methods

    public function safeDelete()
    {
        $this->reminders()->delete();
        $this->collaborators()->detach();

        $this->delete();
    }
}
