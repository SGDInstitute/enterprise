<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddedToTicket extends Notification implements ShouldQueue
{
    use Queueable;

    public $causer;

    public $invitation;

    public $ticket;

    public function __construct($ticket, $invitation, $causer = 'someone')
    {
        $this->ticket = $ticket;
        $this->invitation = $invitation;
        $this->causer = $causer;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $event = $this->ticket->order->event->name;

        return (new MailMessage)
            ->subject('Invited to attend ' . $event)
            ->line("This invitation was sent to: {$this->invitation->email}")
            ->line("You have been invited to attend {$event} by {$this->causer}. Click the link below to accept and add your information (e.g. pronouns, accessibility requests) to the ticket.")
            ->action('Accept Invitation', $this->invitation->acceptUrl);
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }

    public function shouldSend(): bool
    {
        return $this->invitation === null;
    }
}
