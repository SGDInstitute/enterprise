<?php

namespace App\Notifications;

use App\Models\Invitation;
use App\Models\Response;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptInviteReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public Invitation $invitation;
    public Model $model;

    public function __construct(Invitation $invitation, $model = null)
    {
        $this->invitation = $invitation;
        $this->model = ($model === null) ? $invitation->model : $model;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->cc($this->invitation->inviter->email)
                    ->when(get_class($this->model) === Response::class, function ($message) {
                        $message
                            ->line("This invitation was sent to: {$this->invitation->email}")
                            ->line("This is a reminder that you have a pending invitation to co-present {$this->model->name}.")
                            ->lineIf(in_array($this->model->status, ['confirmed', 'scheduled']), 'It is important to accept the invitation if you plan on presenting. We cannot generate a free ticket for you until the invitation is accepted.');
                    })
                    ->when(get_class($this->model) === Ticket::class, function ($message) {
                        $message
                            ->line("This invitation was sent to: {$this->invitation->email}")
                            ->line("This is a reminder that you have a pending invitation to attend {$this->model->name}.")
                            ->line('It is important to accept the invitation if you plan on attending, so you can fill out dietary restrictions and accessibility requests.');
                    })
                    ->action('Accept Invitation', $this->invitation->acceptUrl);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
