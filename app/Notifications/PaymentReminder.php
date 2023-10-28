<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order)
    {
        $this->order->load('event')->loadCount('tickets');
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line("This is a reminder that you have an outstanding reservation for {$this->order->tickets_count} tickets to {$this->order->event->name}.")
            ->line('Orders can be paid by credit card or by check')
            ->line("If paying by card, once the payment is successful, you'll receive a receipt and confirmation that your order is paid. If you have any issues with your credit card payment, please contact us and we'll do our best to troubleshoot.")
            ->line('If paying by check, please make them payable to "Midwest Institute for Sexuality and Gender Diversity" and mailed to P.O. BOX 1053, East Lansing, MI 48826-1053. As soon as we receive your check, your order will be marked as paid.')
            ->action('Pay Now', route('app.orders.show', ['order' => $this->order]));
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
