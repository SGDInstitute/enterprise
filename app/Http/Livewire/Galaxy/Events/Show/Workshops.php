<?php

namespace App\Http\Livewire\Galaxy\Events\Show;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Event;
use App\Models\Form;
use App\Models\Response;
use Livewire\Component;
use Livewire\WithPagination;

class Workshops extends Component
{
    use WithPagination, WithSorting, WithFiltering;

    public Event $event;

    public $filters =  [
        'search' => ''
    ];
    public $perPage = 25;

    public function render()
    {
        return view('livewire.galaxy.events.show.workshops')
            ->with([
                'workshops' => $this->workshops,
            ]);
    }

    public function getWorkshopsProperty()
    {
        return Response::query()
            ->with(['form', 'collaborators'])
            ->where('type', 'workshop')
            ->where('form_id', $this->event->workshopForm->id)
            ->paginate($this->perPage);
    }
}
