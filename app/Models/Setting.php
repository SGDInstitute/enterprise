<?php

namespace App\Models;

use App\Casts\Multi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'payload' => Multi::class,
    ];

    // Relations

    // Attributes

    // Methods
}
