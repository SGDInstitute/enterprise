<?php

namespace App\Livewire\Galaxy;

use App\Livewire\Traits\WithFiltering;
use App\Livewire\Traits\WithSorting;
use App\Models\Form;
use Livewire\Component;
use Livewire\WithPagination;

class Surveys extends Component
{
    use WithFiltering;
    use WithPagination;
    use WithSorting;

    public $perPage = 10;

    public function render()
    {
        return view('livewire.galaxy.surveys')
            ->layout('layouts.galaxy', ['title' => 'Surveys'])
            ->with([
                'surveys' => $this->surveys,
            ]);
    }

    public function getSurveysProperty()
    {
        return Form::where('type', 'survey')->paginate($this->perPage);
    }
}
