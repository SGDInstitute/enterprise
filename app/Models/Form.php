<?php

namespace App\Models;

use App\Traits\HasSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Form extends Model
{
    use HasFactory;
    use HasSettings;
    use HasSlug;

    public $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // Relations

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    public function confirmation(): HasOne
    {
        return $this->hasOne(Form::class, 'parent_id', 'id')->where('type', 'confirmation');
    }

    public function finalizeForm(): HasOne
    {
        return $this->hasOne(Form::class, 'parent_id', 'id')->where('type', 'finalize');
    }

    public function review(): HasOne
    {
        return $this->hasOne(Form::class, 'parent_id', 'id')->where('type', 'review');
    }

    // Attributes

    public function getDaysLeftAttribute()
    {
        return $this->end->timezone($this->timezone)->diffInDays();
    }

    public function getFormattedDurationAttribute()
    {
        if ($this->start->diffInHours($this->end) > 24) {
            return $this->start->timezone($this->timezone)->format('D, M j') . ' - ' . $this->end->timezone($this->timezone)->format('D, M j, Y');
        } else {
            return $this->start->timezone($this->timezone)->format('D, M j Y g:i a') . ' - ' . $this->end->timezone($this->timezone)->format('g:i a');
        }
    }

    public function getFormattedEndAttribute($override = null)
    {
        if ($override) {
            return $this->end->timezone($this->timezone)->format($override);
        }

        if ($this->timezone === null || $this->end === null) {
            return now()->format('m/d/Y g:i A');
        }

        return $this->end->timezone($this->timezone)->format('m/d/Y g:i A');
    }

    public function getFormattedStartAttribute()
    {
        if ($this->timezone === null || $this->start === null) {
            return now()->format('m/d/Y g:i A');
        }

        return $this->start->timezone($this->timezone)->format('m/d/Y g:i A');
    }

    public function getFormattedTimezoneAttribute()
    {
        if ($this->timezone === 'America/New_York') {
            return 'EST';
        }
        if ($this->timezone === 'America/Chicago') {
            return 'CST';
        }
    }

    public function getHasCollaboratorsAttribute()
    {
        return $this->form->contains('style', 'collaborators') || $this->form->contains('type', 'collaborators');
    }

    public function getHasRemindersAttribute()
    {
        return $this->settings->has('reminders');
    }

    public function getPreviewUrlAttribute()
    {
        return route('app.forms.show', $this);
    }

    public function getQuestionsAttribute()
    {
        return $this->form
            ->when(Arr::get($this->form->first(), 'type') !== null, fn ($collection) => $collection->filter(fn ($item) => $item['type'] === 'question'))
            ->when(Arr::get($this->form->first(), 'style') !== null, fn ($collection) => $collection->filter(fn ($item) => $item['style'] === 'question'));
    }

    public function getRulesAttribute()
    {
        return $this->form
            ->when(isset($this->form->first()['data']), function ($collection) {
                return $collection->map(fn ($item) => [...$item['data'], 'style' => $item['type']]);
            })
            ->filter(fn ($item) => $item['style'] === 'question')
            ->mapWithKeys(function ($question) {
                return ['answers.' . $question['id'] => $question['rules'] ?? []];
            })->toArray();
    }

    public function getValidationAttributesAttribute()
    {
        return collect($this->rules)
            ->map(fn ($rule, $key) => Str::of($key)->replace('answers.', '')->replace('-', ' ')->replace('_', ' ')->toString())
            ->toArray();
    }

    protected function casts(): array
    {
        return [
            'auth_required' => 'boolean',
            'end' => 'datetime',
            'form' => 'collection',
            'is_internal' => 'boolean',
            'settings' => 'array',
            'start' => 'datetime',
        ];
    }
}
