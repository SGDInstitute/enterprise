<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'answers' => 'collection',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'collaborators');
    }
}
