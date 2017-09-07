<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function findByEmail($value)
    {
        $user = self::where('email', $value)->first();
        return $user;
    }

    public function getImageAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email)));
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function token()
    {
        return $this->hasOne(UserToken::class);
    }

    public function emailToken()
    {
        return $this->hasOne(UserToken::class)->where('type', 'email');
    }

    public function magicToken()
    {
        return $this->hasOne(UserToken::class)->where('type', 'magic');
    }

    public function changePassword($new)
    {
        $this->password = bcrypt($new);
        $this->save();

        return $this;
    }

    public function createToken($type)
    {
        return $this->token()->create([
            'token' => str_random(50),
            'type' => $type,
        ]);
    }

    public function confirm() {
        $this->confirmed_at = Carbon::now();
        $this->save();
        $this->emailToken->delete();
    }

    public function isConfirmed()
    {
        return ! is_null($this->confirmed_at);
    }
}
