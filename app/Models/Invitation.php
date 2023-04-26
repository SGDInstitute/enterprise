<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\URL;

class Invitation extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the parent invite model (ticket or response).
     */
    public function inviteable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getAcceptUrlAttribute()
    {
        return URL::signedRoute('invitations.accept', [
            'invitation' => $this,
        ]);
    }

    public function accept()
    {
        if ($this->inviteable_type === Response::class) {
            $response = $this->inviteable;
            $response->collaborators()->attach(auth()->user());

            $this->delete();

            return redirect()->route('app.forms.show', ['form' => $response->form, 'edit' => $response]);
        } elseif ($this->inviteable_type === Ticket::class) {
            $ticket = $this->inviteable;
            $ticket->update(['user_id' => auth()->id()]);

            $this->delete();

            return redirect()->route('app.orders.show', ['order' => $ticket->order]);
        }
    }
}
