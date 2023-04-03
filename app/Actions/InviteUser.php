<?php

namespace App\Actions;

use App\Mail\InviteUser as MailInviteUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class InviteUser
{
    /**
     * Invite a new user to the given model.
     *
     * For Ticket inviting attendee
     * For Response inviting collaborator
     */
    public function invite(User $user, Model $model, string $email)
    {
        $invitation = $model->invitations()->create([
            'invited_by' => $user->id,
            'email' => $email,
        ]);

        Mail::to($email)->send(new MailInviteUser($invitation));

        return $invitation;
    }
}
