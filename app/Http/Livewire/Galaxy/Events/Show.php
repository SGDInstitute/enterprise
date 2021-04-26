<?php

namespace App\Http\Livewire\Galaxy\Events;

use App\Models\Event;
use Livewire\Component;

class Show extends Component
{
    public $page;
    public Event $event;

    public function mount($page = 'dashboard')
    {
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.galaxy.events.show')
            ->layout('layouts.galaxy', ['title' => $this->event->name])
            ->with([
                'pages' => $this->pages,
                'action' => ['label' => 'Configure', 'href' => route('galaxy.events.edit', $this->event)],
            ]);
    }

    public function getPagesProperty()
    {
        return [
            ['value' => 'details', 'label' => 'Dashboard', 'href' => route('galaxy.events.show', ['event' => $this->event, 'page' => 'dashboard']), 'icon' => 'heroicon-o-home', 'active' => $this->page === 'dashboard'],
            ['value' => 'reservations', 'label' => 'Reservations', 'href' => route('galaxy.events.show', ['event' => $this->event, 'page' => 'reservations']), 'icon' => 'heroicon-o-camera', 'active' => $this->page === 'reservations'],
            ['value' => 'orders', 'label' => 'Orders', 'href' => route('galaxy.events.show', ['event' => $this->event, 'page' => 'orders']), 'icon' => 'heroicon-o-ticket', 'active' => $this->page === 'orders'],
            ['value' => 'workshops', 'label' => 'Workshops', 'href' => route('galaxy.events.show', ['event' => $this->event, 'page' => 'workshops']), 'icon' => 'heroicon-o-ticket', 'active' => $this->page === 'workshops'],
        ];
    }
}