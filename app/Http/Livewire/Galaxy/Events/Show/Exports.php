<?php

namespace App\Http\Livewire\Galaxy\Events\Show;

use App\Exports\TicketAnswersExport;
use App\Exports\TicketUsersExport;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Exports extends Component
{
    public Event $event;

    public $allUsers = [
        'ticket_type' => '',
        'status' => 'both',
    ];

    public $ticketAnswers = [
        'ticket_type' => '',
        'question' => '',
        'status' => 'both',
    ];

    public function render()
    {
        return view('livewire.galaxy.events.show.exports')
            ->with([
                'questions' => $this->questions
            ]);
    }

    public function getQuestionsProperty()
    {
        $ticketType = $this->event->ticketTypes->find($this->ticketAnswers['ticket_type']);
        if ($ticketType !== null) {
            return $ticketType->form->pluck('question', 'id');
        }

        return [];
    }

    public function generateAllUsers()
    {
        return Excel::download(
            new TicketUsersExport($this->event->id, $this->allUsers['ticket_type'], $this->allUsers['status']),
            'users.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }

    public function generateTicketAnswers()
    {
        $ticketType = Str::slug($this->event->ticketTypes->find($this->ticketAnswers['ticket_type'])->name);

        return Excel::download(
            new TicketAnswersExport($this->event->id, $this->ticketAnswers['ticket_type'], $this->ticketAnswers['question'], $this->ticketAnswers['status']),
            "{$ticketType}-{$this->ticketAnswers['question']}-answers-{$this->ticketAnswers['status']}.csv",
            \Maatwebsite\Excel\Excel::CSV
        );
    }
}
