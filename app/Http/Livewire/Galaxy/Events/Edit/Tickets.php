<?php

namespace App\Http\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use Livewire\Component;
use App\Models\TicketType;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use App\Http\Livewire\Traits\WithSorting;
use App\Http\Livewire\Traits\WithFiltering;

class Tickets extends Component
{
    use WithSorting, WithFiltering, WithPagination;

    protected $listeners = ['refresh' => '$refresh'];

    public Event $event;

    public $filters =  [
        'search' => '',
    ];

    public $rules = [
        'editing.type' => '',
        'editing.name' => '',
        'editing.description' => '',
        'editing.num_tickets' => '',
        'costInDollars' => '',
        'formattedStart' => '',
        'formattedEnd' => '',
    ];

    public $editing;
    public $costInDollars;
    public $formattedStart;
    public $formattedEnd;
    public $formChanged = false;
    public $perPage = 10;
    public $showModal = false;

    public function mount()
    {
        $this->editing = TicketType::make(['event_id' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.tickets')
            ->with([
                'ticketTypes' => $this->rows
            ]);
    }

    public function getRowsProperty()
    {
        return TicketType::query()
            ->when($this->filters['search'], function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . trim($this->filters['search']) . '%');
                });
            })
            ->where('event_id', $this->event->id)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function remove($id)
    {
        $tt = $this->rows->find($id);
        $tt->safeDelete();

        $this->emit('refresh');
        $this->emit('notify', ['message' => 'Successfully deleted ticket type.', 'type' => 'success']);
    }

    public function save()
    {
        $this->validate();

        $this->editing->event_id = $this->event->id;
        $this->editing->start = Carbon::parse($this->formattedStart, $this->event->timezone)->timezone('UTC');
        $this->editing->end = Carbon::parse($this->formattedEnd, $this->event->timezone)->timezone('UTC');
        $cost = $this->costInDollars * 100;

        $this->editing->cost = $cost;

        $this->editing->save();
        $this->showModal = false;
        $this->emit('notify', ['message' => 'Successfully saved ticket type.', 'type' => 'success']);
    }

    public function showCreateModal()
    {
        if($this->editing->id) {
            $this->editing = TicketType::make(['event_id' => $this->event->id]);
        }
        $this->showModal = true;
    }

    public function showEditModal($id)
    {
        $this->editing = $this->rows->find($id);
        $this->costInDollars = $this->editing->costInDollars;
        $this->formattedStart = $this->editing->formattedStart;
        $this->formattedEnd = $this->editing->formattedEnd;
        $this->showModal = true;
    }
}
