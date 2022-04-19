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
            return match ($this->policyModal) {
                'description' => 'Event Description',
                'refund' => 'Refund Policy',
                'code-inclusion' => 'Code for Inclusion',
                'photo-policy' => 'Photo Policy',
            };
        }
    }

    public function getModalContentProperty()
    {
        if ($this->policyModal) {
            $tabs = collect($this->event->settings->tabs);
            return match ($this->policyModal) {
                'description' => $this->event->description,
                'refund' => $tabs->firstWhere('name', 'Refund')['content'],
                'code-inclusion' => $tabs->firstWhere('name', 'Code for Inclusion')['content'],
                'photo-policy' => $tabs->firstWhere('name', 'Photo Policy')['content'],
            };
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
