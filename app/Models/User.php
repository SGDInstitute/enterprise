<?php

namespace App\Models;

use App\Traits\HasProfilePhoto;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Stripe\Customer;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use Billable;
    use HasProfilePhoto;
    use Impersonate;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'array',
        'terms' => 'array',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['institute', 'mblgtacc_planner', 'mblgtacc', 'developer']);
    }

    // Relationships

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function incompleteDonations(): HasMany
    {
        return $this->donations()->where('status', 'incomplete');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function paidOrders(): HasMany
    {
        return $this->hasMany(Order::class)->paid();
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Order::class)->reservations();
    }

    public function responseOwner(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    public function responses(): BelongsToMany
    {
        return $this->belongsToMany(Response::class, 'collaborators');
    }

    public function schedule(): BelongsToMany
    {
        return $this->belongsToMany(EventItem::class, 'user_schedule', 'user_id', 'item_id');
    }

    public function shifts(): BelongsToMany
    {
        return $this->belongsToMany(Shift::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    // Attributes

    public function getFormattedAddressAttribute()
    {
        if (is_array($this->address)) {
            return isset($this->address['line2'])
                ? "{$this->address['line1']} {$this->address['line2']}, {$this->address['city']}, {$this->address['state']}, {$this->address['zip']}"
                : "{$this->address['line1']}, {$this->address['city']}, {$this->address['state']}, {$this->address['zip']}";
        }
    }

    public function getFormattedNameAttribute()
    {
        return $this->pronouns ? "{$this->name} ({$this->pronouns})" : $this->name;
    }

    public function getHasInvitationsAttribute()
    {
        return Invitation::where('email', $this->email)->exists();
    }

    // Methods

    public function acceptTerms($event)
    {
        $terms = $this->terms;
        $terms[$event->slug] = now();
        $this->update(['terms' => $terms]);
    }

    public function findOrCreateCustomerId()
    {
        if ($this->stripe_id) {
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

    public function hasCompedTicketFor($event)
    {
        return $this->tickets()->whereHas('order', function (Builder $query) use ($event) {
            $query
                ->where('event_id', $event->id)
                ->where('transaction_id', 'like', '%comped%');
        })->exists();
    }

    public function hasTicketFor($event)
    {
        return $this->tickets()->where('event_id', $event->id)->exists();
    }

    public function isCheckedInFor($event)
    {
        $ticket = $this->ticketForEvent($event);
        return $ticket ? $ticket->isQueued() : false;
    }

    public function isRegisteredFor($event)
    {
        return $this->tickets()->orderFor($event)->exists();
    }

    public function isInSchedule($item)
    {
        return $this->schedule()->where('item_id', $item->id)->exists();
    }

    public function routeNotificationForVonage($notification)
    {
        return $this->attributes['phone'];
    }

    public function ticketForEvent($event)
    {
        $registered = $this->isRegisteredFor($event);

        return $this->tickets()
            ->when($registered, fn ($query) => $query->orderFor($event)
            )
            ->when(! $registered, fn ($query) => $query->where('event_id', $event->id)
            )
            ->first();
    }

    protected function notificationsVia(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value === null ? [] : json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (empty($value) || strlen($value) === 0 || $value === '' || $value === '' || $value === null || $value === '() -') {
                    return null;
                }

                $area = substr($value, 1, 3);
                $mid = substr($value, 4, 3);
                $last = substr($value, 7, 4);

                $formatted = "({$area}) {$mid}-{$last}";

                if ($formatted === '() -') {
                    return null;
                }

                return $formatted;
            },
            set: fn ($value) => Str::of($value)->replace(' ', '')->replace('(', '')->replace(')', '')->replace('-', '')->prepend(1),
        );
    }
}
