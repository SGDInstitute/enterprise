<?php

namespace App\Http\Livewire\App\Donations;

use Livewire\Component;

class Create extends Component
{
    public $form = [
        'name' => '',
        'email' => '',
        'is_anonymous' => false,
        'is_company' => false,
        'company_name' => '',
        'tax_id' => '',
        'type' => '',
        'amount' => '25.00',
    ];

    public function mount()
    {
        if(auth()->check()) {
            $this->form['name'] = auth()->user()->name;
            $this->form['email'] = auth()->user()->email;
        }
    }

    public function render()
    {
        return view('livewire.app.donations.create');
    }
}
