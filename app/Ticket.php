<?php

namespace App;

use App\Mail\InviteUserEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\Facades\Hashids;

class Ticket extends Model
{
    protected $fillable = ['ticket_type_id'];

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
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function findByHash($hash)
    {
        return self::where('hash', $hash)->first();
    }

    public function scopeFilled($query)
    {
        return $query->whereNotNull('user_id');
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
        $this->save();

        $user->profile->update($data);
    }
}
