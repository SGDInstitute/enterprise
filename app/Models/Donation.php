<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    public $guarded = [];

    public $casts = ['is_anonymous' => 'boolean', 'is_company' => 'boolean'];

    // Relations

    // Attributes

    // Methods
}
