<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdateProfile extends Notification
{
    use Queueable;

    public $user;
    
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('emails.profile', ['user' => $this->user, 'url' => url('/home#settings')]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
