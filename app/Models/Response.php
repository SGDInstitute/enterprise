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

    public function reminders()
    {
        return $this->morphMany(Reminder::class, 'model');
    }

    public function reviews()
    {
        return $this->hasMany(Response::class, 'parent_id', 'id')->where('type', 'rubric');
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
        if ($this->type === 'rubric') {
            return $this->answers->mapWithKeys(function ($item, $key) {
                return [$key => array_sum(array_column($item, 'points'))];
            });
        } elseif ($this->type === 'workshop') {
            $keys = $this->reviews->first()->answers->keys();
            $scores = [];

            foreach($keys as $key) {
              $scores[$key] = $this->reviews->map->score->avg($key);
            }
            return join('<br />', $scores);
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
            ->filter(fn($d) => $d <= $this->form->end)
            ->map(fn($d) => ['send_at' => $d]);

        $this->reminders()->createMany($dates);
    }
}
