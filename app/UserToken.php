<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class UserToken extends Model
{
    use LogsActivity;

    protected $fillable = ['token', 'type'];

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

    public function belongsToUser($email)
    {
        $user = User::findByEmail($email);

        $tokenType = "{$this->type}Token";

        if(!$user || $user->$tokenType == null) {
            return false;
        }

        return ($this->token === $user->$tokenType->token);
    }
}
