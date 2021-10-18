<?php

namespace App\Http\Livewire\Galaxy;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Form;
use Livewire\Component;
use Livewire\WithPagination;

class Surveys extends Component
{
    use WithFiltering, WithPagination, WithSorting;

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
