<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddedToTicket extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;

    public $newUser;

    public $causer;

    public function __construct($ticket, $newUser = 'false', $causer = 'someone')
    {
        $this->ticket = $ticket;
        $this->newUser = $newUser;
        $this->causer = $causer;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())->markdown('mail.added-to-ticket', [
            'ticket' => $this->ticket,
            'newUser' => $this->newUser,
            'causer' => $this->causer,
            'event' => $this->ticket->order->event->name,
            'resetUrl' => route('password.request'),
            'homeUrl' => url('/dashboard'),
        ]);
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
