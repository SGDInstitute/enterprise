<?php

namespace App\Notifications;

use App\Models\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddedAsCollaborator extends Notification implements ShouldQueue
{
    use Queueable;

    public Response $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Added as collaborator to ' . $this->response->name)
            ->line('We are letting you know that you have been added as a collaborator to ' . $this->response->name . '.')
            ->line('You can work on the submission with the other collaborators and submit it for review.')
            ->action('View Submission', route('app.forms.show', ['form' => $this->response->form, 'edit' => $this->response]));
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
