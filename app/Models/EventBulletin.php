<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBulletin extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = ['published_at' => 'datetime'];

    // Relations

    // Attributes

    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at->timezone($this->timezone)->format('D g:i a');
    }

    public function getIsPublishedAttribute()
    {
        return $this->published_at < now();
    }

    // Methods
}
