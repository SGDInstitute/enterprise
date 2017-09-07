<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $fillable = ['token'];

    /**
     * A token belongs to a registered user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function isExpired()
    {
        return $this->created_at->diffInMinutes(Carbon::now()) > 10;
    }
}
