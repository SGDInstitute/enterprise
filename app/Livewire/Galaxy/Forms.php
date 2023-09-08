<?php

namespace App\Livewire\Galaxy;

use App\Livewire\Traits\WithFiltering;
use App\Livewire\Traits\WithSorting;
use App\Models\Form;
use Livewire\Component;
use Livewire\WithPagination;

class Forms extends Component
{
    use WithFiltering;
    use WithPagination;
    use WithSorting;

    public $filters = ['search' => ''];

    public $perPage = 10;

    public function render()
    {
        return view('livewire.galaxy.forms')
            ->layout('layouts.galaxy', ['title' => 'Forms'])
            ->with([
                'forms' => $this->forms,
            ]);
    }

    public function getFormsProperty()
    {
        return Form::withCount('responses')
            ->orderBy($this->sortField, $this->sortDirection)
            ->where(function ($query) {
                $search = trim($this->filters['search']);
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('type', 'LIKE', "%{$search}%");
            })
            ->paginate($this->perPage);
    }
}
