<?php

namespace App\Http\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class Media extends Component
{
    use WithMedia;

    public Event $event;

    public $mediaComponentNames = ['background', 'logo'];

    public $icon;

    public function render()
    {
        return view('livewire.galaxy.events.edit.media')
            ->with([
                'backgroundSrc' => $this->backgroundSrc,
                'logoSrc' => $this->logoSrc,
            ]);
    }

    public function getBackgroundSrcProperty()
    {
        if($this->background !== null) {
            return array_values($this->background)[0]['previewUrl'];
        }

        return $this->event->getFirstMediaUrl('background');
    }

    public function getLogoSrcProperty()
    {
        if($this->logo !== null) {
            return array_values($this->logo)[0]['previewUrl'];
        }

        return $this->event->getFirstMediaUrl('logo');
    }

    public function save()
    {
        $this->event->syncFromMediaLibraryRequest($this->background)->toMediaCollection('background');
        $this->event->syncFromMediaLibraryRequest($this->logo)->toMediaCollection('logo');
    }
}
