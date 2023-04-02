<?php

namespace App\Traits;

use App\Models\Invitation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\SchemalessAttributes\SchemalessAttributes;

trait HasInvitations
{
    public function invitations(): MorphMany
    {
        return $this->morphMany(Invitation::class, 'inviteable');
    }
}
