<?php

namespace App;

use App\Mail\InviteUserEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\Traits\LogsActivity;
use Vinkla\Hashids\Facades\Hashids;

class Ticket extends Model
{
    use LogsActivity, SoftDeletes;

    protected $fillable = ['ticket_type_id'];

    protected $dates = ['deleted_at'];

    /**
     * Boot function for using with User Events
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->hash = Hashids::encode($model->id);
            $model->save();
        });
    }

    public function ticket_type()
    {
        return $this->belongsTo(TicketType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(new User());
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function findByHash($hash)
    {
        return self::where('hash', $hash)->first();
    }

    public static function findByIds($ids)
    {
        return self::whereIn('id', $ids)->get();
    }

    public function scopeFilled($query)
    {
        return $query->whereNotNull('user_id');
    }

    public function scopeCompleted($query)
    {
        return $query->join('profiles', 'profiles.user_id', 'tickets.user_id')->whereNotNull('profiles.tshirt');
    }

    public function isComplete()
    {
        return !is_null($this->user->profile->tshirt);
    }

    public function isFilled()
    {
        return !is_null($this->user_id);
    }

    public function scopeUpcoming($query)
    {
        return $query->select('tickets.*', 'events.start')
            ->join('orders', 'tickets.order_id', '=', 'orders.id')
            ->join('events', 'orders.event_id', '=', 'events.id')
            ->whereDate('end', '>', Carbon::now());
    }

    public function scopePast($query)
    {
        return $query->select('tickets.*', 'events.start')
            ->join('orders', 'tickets.order_id', '=', 'orders.id')
            ->join('events', 'orders.event_id', '=', 'events.id')
            ->whereDate('end', '<', Carbon::now());
    }

    public function invite($email, $note = null)
    {
        $invitee = User::findByEmail($email);

        if (is_null($invitee)) {
            $invitee = User::create(['email' => $email, 'password' => str_random(50)]);
        }

        $this->user_id = $invitee->id;
        $this->save();

        Mail::to($invitee->email)->send(new InviteUserEmail($invitee, request()->user(), $this, $note));
    }

    public function fillManually($data)
    {
        $user = User::create([
            'name' => array_get($data, 'name'),
            'email' => array_get($data, 'email'),
            'password' => str_random(50),
        ]);

        $this->user_id = $user->id;
        $this->type = 'manual';
        $this->save();

        $user->profile->update($data);

        if (isset($data['send_email']) && $data['send_email']) {
            Mail::to($user->email)->send(new InviteUserEmail($user, request()->user(), $this, array_get($data, 'message')));
        }
    }
}
