<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\URL;

class Invitation extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the parent invite model (ticket or response).
     */
    public function inviteable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getAcceptUrlAttribute()
    {
        return URL::signedRoute('invitations.accept', [
            'invitation' => $this,
        ]);
    }
}
