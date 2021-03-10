<?php

namespace App\Http\Livewire\Bit;

use App\Models\Event as Model;
use Livewire\Component;

class Event extends Component
{
    public Model $event;
    public $background;
    public $logo;

    public function mount($background, $logo)
    {
        $this->background = $background;
        $this->logo = $logo;
    }

    public function render()
    {
        return view('livewire.bit.event');
    }
}
