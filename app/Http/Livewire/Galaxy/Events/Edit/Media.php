<?php

namespace App\Http\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class Media extends Component
{
    use WithMedia;

    public Event $event;

    public $mediaComponentNames = ['icon'];

    public $icon;

    public function render()
    {
        return view('livewire.galaxy.events.edit.media')
            ->with([
                'iconSrc' => $this->iconSrc,
            ]);
    }

    public function getIconSrcProperty()
    {
        if($this->icon !== null) {
            return array_values($this->icon)[0]['previewUrl'];
        }

        return $this->event->getFirstMediaUrl('icon');
    }

    public function save()
    {
        $this->event->syncFromMediaLibraryRequest($this->icon)->toMediaCollection('icon');
    }
}
