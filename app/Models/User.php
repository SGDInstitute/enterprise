<?php

namespace App\Models;

use App\Traits\HasProfilePhoto;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, Billable, HasProfilePhoto, Impersonate;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function responses()
    {
        return $this->belongsToMany(Response::class, 'collaborators');
    }

    public function schedule()
    {
        return $this->belongsToMany(EventItem::class, 'user_schedule', 'user_id', 'item_id');
    }

    public function isInSchedule($item)
    {
        return $this->schedule()->where('item_id', $item->id)->exists();
    }

    public function ticketForEvent($event)
    {
        return Ticket::where('event_id', $event->id)->where('user_id', $this->id)->firstOrFail();
    }
}
