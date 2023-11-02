<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketUsersExport implements FromCollection, WithHeadings
{
    public function __construct(public Event $event, public $status)
    {
    }

    public function collection()
    {
        return Ticket::join('orders', 'tickets.order_id', 'orders.id')
            ->where('orders.event_id', $this->event->id)
            ->when($this->status === 'paid', fn ($query) => $query->whereNotNull('paid_at'))
            ->when($this->status === 'unpaid', fn ($query) => $query->whereNull('paid_at'))
            ->select('tickets.*', 'orders.paid_at')
            ->get()
            ->groupBy('order_id')
            ->flatMap(function ($tickets, $orderId) {
                $order = $tickets->first()->order;
                if (is_null($order)) {
                    return;
                }
                $owner = [
                    'order_id' => $order->id,
                    'name' => $order->user->name ?? '',
                    'email' => $order->user->email ?? '',
                    'pronouns' => $order->user->pronouns ?? '',
                    'transaction_id' => $order->transaction_id,
                    'ticket_type_id' => 'Order Owner',
                    'ticket_id' => '',
                ];
                $tickets = $tickets->map(fn ($ticket) => [
                    'order_id' => $ticket->order_id,
                    'name' => $ticket->user->name ?? '',
                    'email' => $ticket->user->email ?? '',
                    'pronouns' => $ticket->user->pronouns ?? '',
                    'transaction_id' => $order->transaction_id,
                    'ticket_type_id' => $ticket->ticketType->name,
                    'ticket_id' => $ticket->id,
                ]);

                if ($order->tickets->contains('user_id', $order->user_id)) {
                    return $tickets;
                }

                return [$owner, ...$tickets];
            });
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Name',
            'Email',
            'Pronouns',
            'Transaction ID',
            'Ticket Type',
            'Ticket ID',
        ];
    }
}
