<?php

namespace App\Http\Livewire\App\Forms;

use App\Models\Form;
use Livewire\Component;

class Show extends Component
{

    public Form $form;

    public function render()
    {
        return view('livewire.app.forms.show');
    }
}
