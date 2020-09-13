<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Events\UserCreated;
use App\Mail\UserConfirmationEmail;
use Carbon\Carbon;
use DigitalCloud\ModelNotes\HasNotes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Stripe\Customer;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;

    use Notifiable, LogsActivity, SoftDeletes, HasRoles, HasApiTokens, HasNotes;

    protected $fillable = [
        'name', 'email', 'password',
    ];

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
        return 'https://www.gravatar.com/avatar/'.md5(strtolower(trim($this->email)));
    }

    public function routeNotificationForSlack($notification)
    {
        return 'https://hooks.slack.com/services/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';
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }

    public function schedule()
    {
        return $this->belongsToMany(Activity::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class)->withDefault(new Profile());
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function tokens()
    {
        return $this->hasMany(UserToken::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(TicketType::class, 'discounts');
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
            'token' => Str::random(50),
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
            'source' => $token,
        ], ['api_key' => getStripeSecret($group)]);

        $field = "{$group}_stripe_id";
        $this->$field = $customer->id;
        $this->save();
    }

    // public function confirm()
    // {
    //     $this->confirmed_at = Carbon::now();
    //     $this->save();
    //     $this->emailToken->delete();
    // }

    // public function isConfirmed()
    // {
    //     return ! is_null($this->confirmed_at);
    // }

    // public function sendConfirmationEmail()
    // {
    //     $this->confirmed_at = null;
    //     $this->save();
    //     $this->createToken('email');
    //     Mail::to($this)->send(new UserConfirmationEmail($this));
    // }

    public function upcomingOrdersAndTickets()
    {
        return $this->orders()->upcoming()->get()
            ->merge($this->tickets()->upcoming()->get()
                ->map(function ($ticket) {
                    return $ticket->order;
                }));
    }

    public function pastOrdersAndTickets()
    {
        return $this->orders()->past()->get()
            ->merge($this->tickets()->past()->get()
                ->map(function ($ticket) {
                    return $ticket->order;
                }));
    }
}
