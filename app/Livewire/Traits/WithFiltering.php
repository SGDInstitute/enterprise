<?php

namespace App\Livewire\Traits;

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
