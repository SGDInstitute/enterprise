<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class OrderReceipt extends Notification
{
    use Queueable;

    public Order $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $subject = Setting::where('group', 'emails.order-receipt')->where('name', 'subject')->first()->payload;
        $content = Setting::where('group', 'emails.order-receipt.content')->where('name', $this->order->isStripe() ? 'card' : 'check')->first()->payload;
        $parsed = Str::of($content)
            ->replace('{amount}', $this->order->formattedAmount)
            ->replace('{event}', $this->order->event->name)
            ->replace('{tickets}', $this->order->tickets()->count())
            ->replace('{date}', $this->order->created_at->format('F j, Y'));

        return (new MailMessage())
            ->subject($subject)
            ->markdown('mail.email-content', [
                'subject' => $subject,
                'content' => $parsed,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
