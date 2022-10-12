<?php

namespace App\Exports;

use App\Models\EventItem;
use App\Models\Order;
use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketUsersExport implements FromCollection, WithHeadings
{
    public function __construct(public $eventId, public $ticketType, public $status)
    {
    }

    public function collection()
    {
        // return Ticket::
        // return Order::where('event_id', $this->eventId)
        //     ->when($this->status === 'unpaid', fn ($query) => $query->whereNull('transaction_id'))
        //     ->when($this->status === 'paid', fn ($query) => $query->whereNotNull('transaction_id'))
        //     ->get()
        //     ->flatMap(function ($order) {
        //         $owner = [
        //             'order_id' => $order->id,
        //             'name' => $order->user->name ?? '',
        //             'email' => $order->user->email ?? '',
        //             'pronouns' => $order->user->pronouns ?? '',
        //             'transaction_id' => $order->transaction_id,
        //             'ticket_type_id' => 'Order Owner',
        //             'ticket_id' => '',
        //         ];
        //         $tickets = $order->tickets->map(fn ($ticket) => [
        //             'order_id' => $ticket->order_id,
        //             'name' => $ticket->user->name ?? '',
        //             'email' => $ticket->user->email ?? '',
        //             'pronouns' => $ticket->user->pronouns ?? '',
        //             'transaction_id' => $order->transaction_id,
        //             'ticket_type_id' => $ticket->ticketType->name,
        //             'ticket_id' => $ticket->id,
        //         ]);

        //         if ($order->tickets->contains('user_id', $order->user_id)) {
        //             return $tickets;
        //         }

        //         return [$owner, ... $tickets];
        //     });
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
