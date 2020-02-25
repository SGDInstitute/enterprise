<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class ScheduledTask extends Notification
{
    use Queueable;

    public $message;

    public function __construct($message)
    {
        if (env('APP_ENV') === 'local') {
            $message = 'TEST: '.$message;
        }

        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->to('#web')
            ->content($this->message);
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'now' => now(),
        ];
    }
}
