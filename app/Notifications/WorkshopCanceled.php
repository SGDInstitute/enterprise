<?php

namespace App\Notifications;

use App\Models\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkshopCanceled extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Response $workshop)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line("We wanted to let you know that {$this->workshop->name} has been canceled")
                    ->line('Please contact us with any questions.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
