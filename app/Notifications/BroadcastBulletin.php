<?php

namespace App\Notifications;

use App\Models\EventBulletin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class BroadcastBulletin extends Notification implements ShouldQueue
{
    use Queueable;

    public $bulletin;

    public function __construct(EventBulletin $bulletin)
    {
        $this->bulletin = $bulletin;
    }

    public function via($notifiable): array
    {
        return $notifiable->notifications_via === [] ? ['mail'] : $notifiable->notifications_via;
    }

    public function toMail($notifiable): MailMessage
    {
        $subject = $this->bulletin->event->name.' Notification: '.$this->bulletin->title;

        return (new MailMessage())
            ->subject($subject)
            ->markdown('mail.email-content', [
                'subject' => $subject,
                'content' => $this->bulletin->content,
            ]);
    }

    public function toVonage($notifiable)
    {
        return (new VonageMessage)
                    ->content("{$this->bulletin->title}\n\nView Full Text: https://apps.sgdinstitute.org/mblgtacc-2022/program/bulletin-board");
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
