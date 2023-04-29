<?php

namespace App\Models;

use App\Notifications\InvitationAccepted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function getAcceptUrlAttribute()
    {
        return URL::signedRoute('invitations.accept', [
            'invitation' => $this,
        ]);
    }

    public function getRedirectUrlAttribute()
    {
        return match ($this->inviteable_type) {
            Response::class => route('app.forms.show', ['form' => $this->inviteable->form, 'edit' => $this->inviteable]),
            Ticket::class => route('app.orders.show', ['order' => $this->inviteable->order]),
        };
    }

    public function accept()
    {
        $url = $this->redirectUrl;
        if ($this->inviteable_type === Response::class) {
            $response = $this->inviteable;
            $response->collaborators()->attach(auth()->user());
        } elseif ($this->inviteable_type === Ticket::class) {
            $ticket = $this->inviteable;
            $ticket->update(['user_id' => auth()->id()]);
        }

        $this->inviter->notify(new InvitationAccepted($this->inviteable, auth()->user()));
        $this->delete();

        return redirect($url);
    }
}
