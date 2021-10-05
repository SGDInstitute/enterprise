<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCheckIn extends Notification
{
    use Queueable;

    public $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line("It's time to check-in for {$this->event->name}!")
                    ->action('Check-in Now', route('app.checkin', $notifiable->ticketForEvent($this->event)))
                    ->line("Checking in now will help save time when you arrive at MBLGTACC 2021. Be sure to double check that your name and pronouns are accurate.")
                    ->line("We look forward to greeting you soon!");
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
