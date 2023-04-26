<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitationAccepted extends Notification
{
    use Queueable;

    public function __construct(public Model $model, public User $user)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line("{$this->user->name} ({$this->user->email}) has accepted your invitation to " . $this->getModelSpecificMessage());
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function getModelSpecificMessage()
    {
        return match (get_class($this->model)) {
            Response::class => 'to collaborate on ' . $this->model->name,
            Ticket::class => 'to attend ' . $this->model->order->event->name,
        };
    }
}
