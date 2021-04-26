<?php

namespace App\Notifications;

use App\Models\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RemovedAsCollaborator extends Notification implements ShouldQueue
{
    use Queueable;

    public Response $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->error()
            ->subject('Removed as collaborator from ' . $this->response->name)
            ->line('We are just notifing you that you have been removed as a collaborator from ' . $this->response->name . '.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
