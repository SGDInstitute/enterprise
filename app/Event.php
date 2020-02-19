<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Event extends Model
{
    use LogsActivity, SoftDeletes;

    protected $fillable = ['title', 'subtitle', 'description', 'location', 'slug', 'stripe', 'start', 'end', 'published_at'];

    protected $dates = [
        'start', 'end', 'published_at'
    ];

    protected $casts = [
        'links' => 'array',
    ];

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function forms()
    {
        return $this->hasMany(Form::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function ticket_types()
    {
        return $this->hasMany(TicketType::class);
    }

    public function scopeFindBySlug($query, $slug)
    {
        return $query->where('slug', $slug)->firstOrFail();
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->whereDate('published_at', '<=', Carbon::now());
    }

    public function scopeUpcoming($query)
    {
        $query->whereDate('start', '>', Carbon::now());
    }

    public function getFormattedStartAttribute()
    {
        return $this->start->timezone($this->timezone)->format('D, M j');
    }

    public function getFormattedEndAttribute()
    {
        return $this->end->timezone($this->timezone)->format('D, M j');
    }

    public function getDurationAttribute()
    {
        return $this->start->timezone($this->timezone)->format('l F j, Y g:i A')
            .' to '.$this->end->timezone($this->timezone)->format('l F j, Y g:i A T');
    }

    public function getTicketStringAttribute($ticketString)
    {
        return ucwords($ticketString);
    }

    public function hasOrderFor($customerEmail)
    {
        return $this->orders()->where('email', $customerEmail)->count() > 0;
    }

    public function ordersFor($customerEmail)
    {
        return $this->orders()->where('email', $customerEmail)->get();
    }

    public function orderTickets($user, $tickets)
    {
        $order = $this->orders()->create(['user_id' => $user->id]);

        foreach ($tickets as $ticket) {
            if ($ticket['quantity'] > 0) {
                $ticketType = TicketType::find($ticket['ticket_type_id']);

                foreach (range(1, $ticket['quantity']) as $i) {
                    $order->tickets()->create([
                        'ticket_type_id' => $ticket['ticket_type_id']
                    ]);

                    if ($ticketType->cost === 0) {
                        $order->markAsPaid(collect(['id' => 'comped', 'amount' => 0]));
                    }
                }
            }
        }

        return $order;
    }

    public function getPublicKey()
    {
        return config("{$this->stripe}.stripe.key");
    }

    public function getSecretKey()
    {
        return config("{$this->stripe}.stripe.secret");
    }
}
