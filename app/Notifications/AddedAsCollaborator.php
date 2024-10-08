<?php

namespace App\Notifications;

use App\Models\Invitation;
use App\Models\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddedAsCollaborator extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Invitation $invitation, public Response $response) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Invited to be co-presenter on ' . $this->response->name)
            ->line("This invitation was sent to: {$this->invitation->email}. You must use this email address to log in and accept your invitation. It is possible to update your email later.")
            ->line('We are letting you know that you have been added as a co-presenter to ' . $this->response->name . '.')
            ->line('You can work on the submission with the other presenters and submit it for review.')
            ->line('If your presentation is accepted, you will have a ticket automatically created for you.')
            ->action('Accept Invitation', $this->invitation->acceptUrl);
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
