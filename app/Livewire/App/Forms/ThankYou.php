<?php

namespace App\Livewire\App\Forms;

use App\Models\Form;
use Livewire\Component;

class ThankYou extends Component
{
    public Form $form;

    public function render()
    {
        return view('livewire.app.forms.thank-you');
    }
}
