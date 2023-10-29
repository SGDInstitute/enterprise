<?php

namespace App\Livewire\App\Orders;

use App\Models\Order;
use App\Models\Ticket;
use Filament\Notifications\Notification;
use Livewire\Component;

class Attendee extends Component
{
    public Order $order;

    public Ticket $ticket;

    public $answers;

    public $ticketholder;

    public function mount()
    {
        $this->loadTicket();
    }

    public function render()
    {
        return view('livewire.app.orders.attendee', [
            'fillable' => auth()->check(),
        ]);
    }

    public function loadTicket()
    {
        $this->ticket = $this->order->tickets()->where('user_id', auth()->id())->first();

        $this->answers = $this->ticket->answers ?? $this->getAnswerForm($this->ticket);

        if ($this->ticket->user_id !== null) {
            $this->ticketholder = $this->ticket->user->only(['name', 'email', 'pronouns']);
        }
    }

    public function saveTicket()
    {
        // $this->validate();

        $user = auth()->user();
        $user->name = $this->ticketholder['name'];
        $user->pronouns = $this->ticketholder['pronouns'];
        $user->email = $this->ticketholder['email'];
        $user->save();

        $this->ticket->update([
            'answers' => $this->answers,
        ]);

        Notification::make()
            ->success()
            ->title('Successfully saved information.')
            ->send();
    }

    private function getAnswerForm($ticket)
    {
        if (isset($ticket->ticketType->form)) {
            return $ticket->ticketType->form
                        ->filter(fn ($item) => $item['style'] !== 'content')
                        ->mapWithKeys(function ($item) {
                            if ($item['style'] === 'question') {
                                if ($item['type'] === 'list' && $item['list-style'] === 'checkbox') {
                                    return [$item['id'] => []];
                                }

                                return [$item['id'] => ''];
                            } elseif ($item['style'] === 'collaborators') {
                                return [$item['id'] => auth()->user()->email ?? ''];
                            }
                        })->toArray();
        }
    }
}
