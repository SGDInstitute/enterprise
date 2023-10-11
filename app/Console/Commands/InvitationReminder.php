<?php

namespace App\Console\Commands;

use App\Models\Invitation;
use App\Notifications\AcceptInviteReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class InvitationReminder extends Command
{
    protected $signature = 'app:invitation-reminder';

    protected $description = 'Send reminder emails to folks with pending invitations';

    public function handle()
    {
        $this->info('Running reminder emails to pending invitations...');

        $invitations = Invitation::where('updated_at', '<=', now()->subWeek())->get();

        $this->info($invitations->count() . ' reminders need to be sent.');

        $this->info('Sending notifications...');

        $invitations->each(function ($invitation) {
            Notification::route('mail', $invitation->email)->notify(new AcceptInviteReminder($invitation));
        });

        $this->info('Invitation Reminder Complete');
    }
}
