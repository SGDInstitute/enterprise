<?php

namespace App\Models;

use App\Casts\Address;
use App\Traits\HasProfilePhoto;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Stripe\Customer;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Billable, HasProfilePhoto, Impersonate;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'array',
    ];

    // protected static function booted()
    // {
    //     static::updated(queueable(function ($customer) {
    //         $customer->syncStripeCustomerDetails();
    //     }));
    // }

    // Relationships

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function incompleteDonations()
    {
        return $this->donations()->where('status', 'incomplete');
    }

    public function responses()
    {
        return $this->belongsToMany(Response::class, 'collaborators');
    }

    public function schedule()
    {
        return $this->belongsToMany(EventItem::class, 'user_schedule', 'user_id', 'item_id');
    }

    // Methods

    public function findOrCreateCustomerId()
    {
        if($this->stripe_id) {
            return $this->stripe_id;
        } else {
            $customer = Customer::create([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            $this->stripe_id = $customer->id;
            $this->save();

            return $this->stripe_id;
        }
    }

    public function hasRecurringDonation()
    {
        return $this->donations()->whereNull('parent_id')->whereNotNull('subscription_id')->where('status', 'succeeded')->exists();
    }

    public function isInSchedule($item)
    {
        return $this->schedule()->where('item_id', $item->id)->exists();
    }

    public function ticketForEvent($event)
    {
        return Ticket::where('event_id', $event->id)->where('user_id', $this->id)->first();
    }
}
