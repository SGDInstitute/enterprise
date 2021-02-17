<?php

namespace App\Http\Livewire\Galaxy;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\Traits\WithSorting;
use App\Http\Livewire\Traits\WithFiltering;

class Events extends Component
{
    use WithSorting, WithFiltering, WithPagination;

    public $filters =  [
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
        return Event::
            when($this->filters['search'], function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . trim($this->filters['search']) . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }
}
