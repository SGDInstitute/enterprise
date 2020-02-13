<?php

namespace App\Notifications;

use App\Mail\VolunteerShifts as MailVolunteerShifts;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VolunteerShifts extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailVolunteerShifts($notifiable))->to($notifiable->email);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
