<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BadgePrinted extends Notification
{
    use Queueable;

    public $badge;

    public function __construct($badge)
    {
        $this->badge = $badge;
    }

    public function via($notifiable)
    {
        return $notifiable->notifications_via ?? 'email';
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->subject('Your MBLGTACC Name Badge is Ready!')
                    ->line('Your name badge is hot off the presses. Please come to the registration table 4 to pick it up.')
                    ->line('See you soon!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
