<?php

namespace App;

use App\Event;
use App\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Form extends Model
{
    protected $fillable = ['name', 'start', 'end', 'is_public', 'form'];

    protected $casts = [
        'is_public' => 'boolean',
        'form' => 'collection',
    ];

    protected $dates = ['start', 'end'];

    public static function findBySlug($slug)
    {
        return self::where('slug', $slug)->firstOrFail();
    }

    public function scopeOpen($query)
    {
        return $query->where('is_public', true)
            ->whereDate('start', '<=', Carbon::now())
            ->whereDate('end', '>=', Carbon::now());
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getRules()
    {
        return $this->compileRules($this->form, []);
    }

    private function compileRules($form, $rules, $pre = '')
    {
        foreach ($form as $question) {
            if (isset($question['rules'])) {
                $rules["{$pre}{$question['id']}"] = $question['rules'];
            }

            if (isset($question['type']) && $question['type'] === 'repeat') {
                $rules = $this->compileRules($question['form'], $rules, "{$question['id']}.*.");
            }
        }

        return $rules;
    }
}
