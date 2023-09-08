<?php

namespace App\Livewire\Galaxy\Events\Edit;

use App\Livewire\Traits\WithFiltering;
use App\Livewire\Traits\WithSorting;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Tickets extends Component
{
    use WithSorting;
    use WithFiltering;
    use WithPagination;

    public Event $event;

    public $filters = [
        'search' => '',
    ];

    public $editing;

    public $costInDollars;

    public $formattedStart;

    public $formattedEnd;

    public $formChanged = false;

    public $perPage = 10;

    public $showModal = false;

    protected $listeners = ['refresh' => '$refresh'];

    protected $rules = [
        'editing.type' => '',
        'editing.name' => '',
        'editing.description' => '',
        'editing.num_tickets' => '',
        'costInDollars' => '',
        'formattedStart' => '',
        'formattedEnd' => '',
    ];

    public function mount()
    {
        $this->editing = TicketType::make(['event_id' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.tickets')
            ->with([
                'ticketTypes' => $this->rows,
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

        $this->dispatch('notify', ['message' => 'Successfully deleted ticket type.', 'type' => 'success']);
        $this->dispatch('refresh');
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
        $this->dispatch('notify', ['message' => 'Successfully saved ticket type.', 'type' => 'success']);
    }

    public function showCreateModal()
    {
        if ($this->editing->id) {
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
