<?php

namespace App;

use App\Events\UserCreated;
use App\Mail\UserConfirmationEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Stripe\Customer;

class User extends Authenticatable
{
    use Notifiable, LogsActivity, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dispatchesEvents = [
        'created' => UserCreated::class,
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
        return $this->hasOne(Profile::class)->withDefault(new Profile());
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function tokens()
    {
        return $this->hasMany(UserToken::class);
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
        $this->tokens()->where('type', $type)->delete();

        return $this->tokens()->create([
            'token' => str_random(50),
            'type' => $type,
        ]);
    }

    public function isCustomer($group)
    {
        $field = "{$group}_stripe_id";
        return $this->$field !== null;
    }

    public function getCustomer($group)
    {
        $field = "{$group}_stripe_id";
        return $this->$field;
    }

    public function createCustomer($group, $token)
    {
        $customer = Customer::create([
            'email' => $this->email,
            'source'  => $token,
        ], ['api_key' => getStripeSecret($group)]);

        $field = "{$group}_stripe_id";
        $this->$field = $customer->id;
        $this->save();
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

    public function sendConfirmationEmail()
    {
        $this->confirmed_at = null;
        $this->save();
        $this->createToken('email');
        Mail::to($this)->send(new UserConfirmationEmail($this));
    }

    public function upcomingOrdersAndTickets()
    {
        return $this->orders()->upcoming()->get()
            ->merge($this->tickets()->upcoming()->get()
                ->map(function($ticket) {
                    return $ticket->order;
                }));
    }

    public function pastOrdersAndTickets()
    {
        return $this->orders()->past()->get()
            ->merge($this->tickets()->past()->get()
                ->map(function($ticket) {
                    return $ticket->order;
                }));
    }
}
