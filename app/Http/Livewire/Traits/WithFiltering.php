<?php

namespace App\Http\Livewire\Traits;

trait WithFiltering
{
    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
}
