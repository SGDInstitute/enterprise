<?php

namespace App\Actions;

use App\Models\User;
use App\Notifications\AddedAsCollaborator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class InviteUser
{
    /**
     * Invite a new user to the given model.
     *
     * For Ticket inviting attendee
     * For Response inviting collaborator
     */
    public static function invite(User $user, Model $model, string $email)
    {
        $invitation = $model->invitations()->create([
            'invited_by' => $user->id,
            'email' => $email,
        ]);

        Notification::route('mail', $email)->notify(new AddedAsCollaborator($invitation, $model));

        return $invitation;
    }
}
