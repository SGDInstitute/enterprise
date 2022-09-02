<?php

namespace App\Http\Livewire\App\Dashboard;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Response;
use Livewire\Component;
use Livewire\WithPagination;

class Workshops extends Component
{
    use WithPagination;
    use WithSorting;
    use WithFiltering;

    public $form;

    public $filters = [
        'search' => '',
    ];

    public $perPage = 25;

    protected $listeners = ['refresh' => '$refresh'];

    public function render()
    {
        return view('livewire.app.dashboard.workshops')
            ->with([
                'workshops' => $this->workshops,
            ]);
    }

    public function getWorkshopsProperty()
    {
        return Response::query()
            ->with(['form.finalizeForm', 'collaborators'])
            ->where('type', 'workshop')
            ->where('user_id', auth()->id())
            ->when($this->filters['search'], fn($query) => $query
                ->where('answers', 'LIKE', "%{$this->filters['search']}%")
                ->orWhere('status', 'LIKE', "%{$this->filters['search']}%"))
            ->when($this->form, fn($query) => $query->where('form_id', $this->form->id))
            ->paginate($this->perPage);
    }

    public function delete($id)
    {
        $this->workshops->find($id)->safeDelete();

        $this->emit('notify', ['message' => 'Successfully deleted workshop submission', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function finalizeFormNeeded($workshop)
    {
        return in_array($workshop->status, ['confirmed', 'scheduled', 'approved'])
            && !$workshop->form->finalizeForm->responses()->where('parent_id', $workshop->id)->exists();
    }
}
