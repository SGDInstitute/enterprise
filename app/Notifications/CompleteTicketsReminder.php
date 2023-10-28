<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompleteTicketsReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order)
    {
        $this->order->load('event', 'tickets.invitations');
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $ticketsCount = $this->order->tickets->count();
        [$invited, $unassigned] = $this->order->tickets->whereNull('user_id')->partition(function ($ticket) {
            return $ticket->invitations->isNotEmpty();
        });

        return (new MailMessage)
            ->line('This ' . ($this->order->isReservation() ? 'reservation' : 'order') . ' has ' . $ticketsCount . ' ticket(s).')
            ->lineIf($invited->count() === 1, "There is {$invited->count()} pending invitation.")
            ->lineIf($invited->count() > 1, "There are {$invited->count()} pending invitations.")
            ->lineIf($unassigned->count() === 1, "There is {$unassigned->count()} ticket that has not been assigned.")
            ->lineIf($unassigned->count() > 1, "There are {$unassigned->count()} tickets that have not been assigned.")
            ->lineIf($this->order->isReservation(), "Please remember, your payment is due by {$this->order->formattedReservationEnds}.")
            ->action('View Order', route('app.orders.show', ['order' => $this->order]));
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
