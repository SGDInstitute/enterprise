<?php

namespace App\Notifications;

use App\Models\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProposalApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Response $response) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->markdown('mail.proposal-approved', [
            'name' => $this->response->name,
            'url' => $this->response->url,
        ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
