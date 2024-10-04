<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Refund extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order, public $amount, public $count) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $formattedAmount = '$' . number_format($this->amount / 100, 2);

        return (new MailMessage)
            ->subject('Refund for ' . $this->order->confirmation_number . ' Processed')
            ->when(
                $this->order->isStripe(),
                fn ($mail) => $mail->line("This is an automatic message to let you know {$this->count} ticket(s) for {$this->order->event->name} have been refunded.
                It may take 5-7 days for the refund of {$formattedAmount} to be applied to your original form of payment,
                depending on how fast your payment processor applies the credit.")
            )
            ->when(
                ! $this->order->isStripe(),
                fn ($mail) => $mail->line("This is an automatic message to let you know {$this->count} ticket(s) for {$this->order->event->name} have been refunded.
                A check for the amount of {$formattedAmount} will be mailed to you.")
            )
            ->when(
                $this->order->deleted_at,
                fn ($mail) => $mail->line('Since all tickets for this order have been refunded, we went ahead and deleted the order.')
            );
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
