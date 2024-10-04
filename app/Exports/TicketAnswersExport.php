<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketAnswersExport implements FromCollection, WithHeadings
{
    public function __construct(public Event $event, public string $question, public string $status) {}

    public function collection()
    {
        return Ticket::join('orders', 'tickets.order_id', 'orders.id')
            ->where('orders.event_id', $this->event->id)
            ->where("answers->{$this->question}", '<>', '[]')
            ->when($this->status === 'paid', fn ($query) => $query->whereNotNull('paid_at'))
            ->when($this->status === 'unpaid', fn ($query) => $query->whereNull('paid_at'))
            ->select('tickets.*', 'orders.paid_at')
            ->get()
            ->map(function ($ticket) {
                $answers = $ticket->answers[$this->question];
                if (in_array('other', $ticket->answers[$this->question])) {
                    $index = array_search('other', $ticket->answers[$this->question]);
                    $answers[$index] = $ticket->answers[$this->question . '-other'] ?? 'not answered';
                }

                return [
                    'order_id' => $ticket->order_id,
                    'name' => $ticket->user->name ?? '',
                    'email' => $ticket->user->email ?? '',
                    'pronouns' => $ticket->user->pronouns ?? '',
                    'ticket_id' => $ticket->id,
                    'answers' => implode(', ', $answers) ?? '',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Name',
            'Email',
            'Pronouns',
            'Ticket ID',
            'Answers',
        ];
    }
}
