<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfpReview extends Model
{
    use HasFactory;

    public $guarded = [];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function response(): BelongsTo
    {
        return $this->belingsTo(Response::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
