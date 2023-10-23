<?php

namespace App\Notifications;

use App\Models\Response;
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
        $class = get_class($this->model);

        if ($class === Response::class) {
            return $this->getResponseMessage();
        } elseif ($class === Ticket::class) {
            return $this->getTicketMessage();
        }
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    private function getResponseMessage()
    {
        return (new MailMessage)
            ->line("{$this->user->name} ({$this->user->email}) has accepted your invitation to collaborate on {$this->model->name}.")
            ->action('View ' . $this->model->type, route('app.forms.show', ['form' => $this->model->form, 'edit' => $this->model]));
    }

    private function getTicketMessage()
    {
        $order = $this->model->load('order')->order;
        $numberOfOutstandingInvitations = Ticket::whereOrderId($order->id)->whereNull('user_id')->whereHas('invitations')->count();
        $numberOfTicketsThatNeedInvitations = Ticket::whereOrderId($order->id)->whereNull('user_id')->whereDoesntHave('invitations')->count();

        return (new MailMessage)
            ->line("{$this->user->name} ({$this->user->email}) has accepted your invitation to attend {$order->event->name}.")
            ->action('View Order', route('app.orders.show', ['order' => $order]))
            ->lineIf($numberOfOutstandingInvitations === 1, "There is {$numberOfOutstandingInvitations} pending invitation.")
            ->lineIf($numberOfOutstandingInvitations > 1, "There are {$numberOfOutstandingInvitations} pending invitations.")
            ->lineIf($numberOfTicketsThatNeedInvitations === 1, "There is {$numberOfTicketsThatNeedInvitations} ticket that has not been assigned.")
            ->lineIf($numberOfTicketsThatNeedInvitations > 1, "There are {$numberOfTicketsThatNeedInvitations} tickets that have not been assigned.")
            ->lineIf($order->isReservation(), "Please remember, your payment is due by {$order->formattedReservationEnds}.");
    }
}
