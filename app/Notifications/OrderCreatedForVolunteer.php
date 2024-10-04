<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedForVolunteer extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line("We wanted to let you know that you are now registered to attend {$this->order->event->name}. We are happy to provide this complimentary ticket because you are volunteering for 2 or more shifts.")
            ->action('View Order', route('app.orders.show', $this->order))
            ->line('Please contact us with any questions.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
