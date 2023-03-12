<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
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

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject("Time to check-in for {$this->event->name}!")
                    ->line("It's time to check-in for {$this->event->name}!")
                    ->action('Check-in Now', route('app.checkin', $notifiable->ticketForEvent($this->event)))
                    ->line("Checking in now will help save time when you arrive at {$this->event->name}. Be sure to double check that your name and pronouns are accurate.")
                    ->line('We look forward to greeting you soon!');
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
