<?php

namespace App\Livewire\Galaxy;

use App\Livewire\Traits\WithFiltering;
use App\Livewire\Traits\WithSorting;
use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;

class Events extends Component
{
    use WithFiltering;
    use WithPagination;
    use WithSorting;

    public $filters = [
        'search' => '',
    ];

    public $perPage = 25;

    public function render()
    {
        return view('livewire.galaxy.events')
            ->layout('layouts.galaxy', ['title' => 'Events'])
            ->with([
                'events' => $this->rows,
            ]);
    }

    public function getRowsProperty()
    {
        return Event::query()
            ->when($this->filters['search'], function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . trim($this->filters['search']) . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }
}
