<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReminder extends Notification
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('event');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Please pay for your '.$this->order->event->title.' order')
            ->markdown('emails.payment_reminder', ['order' => $this->order, 'url' => url('/orders/'.$this->order->id)]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
