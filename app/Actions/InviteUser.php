<?php

namespace App\Actions;

use App\Mail\InviteUser as MailInviteUser;
use App\Models\Team;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Laravel\Jetstream\Events\InvitingTeamMember;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Mail\TeamInvitation;
use Laravel\Jetstream\Rules\Role;

class InviteUser
{
    /**
     * Invite a new user to the given model.
     * 
     * For Ticket inviting attendee
     * For Response inviting collaborator
     */
    public function invite(User $user, Model $model, string $email): void
    {
        $invitation = $model->invitations()->create([
            'invited_by' => $user->id,
            'email' => $email,
        ]);

        Mail::to($email)->send(new MailInviteUser($invitation));
    }
}