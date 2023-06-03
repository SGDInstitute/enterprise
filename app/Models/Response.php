<?php

namespace App\Models;

use App\Traits\HasInvitations;
use App\Traits\HasSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Response extends Model
{
    use HasFactory;
    use HasInvitations;
    use HasSettings;
    use LogsActivity;

    public $guarded = [];

    protected $casts = [
        'answers' => 'collection',
        'settings' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['answers', 'status'])
            ->logOnlyDirty();
    }

    public function child()
    {
        return $this->hasOne(Response::class, 'parent_id', 'id')->where('form_id', 28);
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

    public function reminders()
    {
        return $this->morphMany(Reminder::class, 'model');
    }

    public function parent()
    {
        return $this->hasOne(Response::class, 'id', 'parent_id');
    }

    public function reviews()
    {
        return $this->hasMany(RfpReview::class);
        // return $this->hasMany(Response::class, 'parent_id', 'id')->where('type', 'review');
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

    public function getScoreAttribute()
    {
        if ($this->type === 'review') {
            if (is_string($this->answers['question-rubric'])) {
                return 0;
            }

            return array_sum($this->answers['question-rubric']);
        } elseif ($this->type === 'workshop') {
            return round($this->reviews->map->score->avg(), 2);
        }
    }

    // Methods

    public function safeDelete()
    {
        $this->reminders()->delete();
        $this->collaborators()->detach();

        $this->delete();
    }

    public function setUpReminders($reminders)
    {
        $dates = str($reminders)->explode(',')
            ->map(function ($d) {
                if (str($d)->startsWith('-')) {
                    return $this->form->end->addDays($d);
                }

                return now()->addDays($d);
            })
            ->filter(fn ($d) => $d <= $this->form->end)
            ->map(fn ($d) => ['send_at' => $d]);

        $this->reminders()->createMany($dates);
    }
}
