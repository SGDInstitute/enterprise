<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VolunteerShifts extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $activities;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->activities = $user->activities->where('schedule_id', 3);
    }

    public function build()
    {
        return $this
            ->from('support@sgdinstitute.org', 'Kate Miller')
            ->markdown('emails.volunteer_shifts');
        // ->attach('/path/to/file', [
            //     'as' => 'name.pdf',
            //     'mime' => 'application/pdf',
            // ]);
    }
}
