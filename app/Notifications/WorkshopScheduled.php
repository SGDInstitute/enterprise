<?php

namespace App\Notifications;

use App\Models\EventItem;
use App\Models\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkshopScheduled extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Response $response, public EventItem $eventItem)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your workshop ' . $this->response->name . ' has been scheduled')
            ->line('Your workshop has been scheduled for ' . $this->eventItem->formattedDuration)
            ->action('View Workshop', route('app.forms.show', ['form' => $this->response->form, 'edit' => $this->response]));
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
