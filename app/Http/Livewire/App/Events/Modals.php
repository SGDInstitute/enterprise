<?php

namespace App\Http\Livewire\App\Events;

use App\Models\Event;
use Livewire\Component;

class Modals extends Component
{
    public Event $event;

    public $policyModal;

    public $showModal = false;

    public function render()
    {
        return view('livewire.app.events.modals', [
            'modalContent' => $this->modalContent,
            'modalTitle' => $this->modalTitle,
        ]);
    }

    public function getModalTitleProperty()
    {
        if ($this->policyModal) {
            return collect($this->event->settings->tabs)->firstWhere('slug', $this->policyModal)['name'] ?? 'Description';
        }
    }

    public function getModalContentProperty()
    {
        if ($this->policyModal === 'description') {
            return $this->event->description;
        } elseif ($this->policyModal) {
            return collect($this->event->settings->tabs)->firstWhere('slug', $this->policyModal)['content'];
        }
    }

    public function resetModal()
    {
        $this->reset('showModal', 'policyModal');
    }

    public function showPolicyModal($type)
    {
        $this->showModal = true;
        $this->policyModal = $type;
    }
}
