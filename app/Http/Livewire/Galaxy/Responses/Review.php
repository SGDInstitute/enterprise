<?php

namespace App\Http\Livewire\Galaxy\Responses;

use App\Models\Form;
use App\Models\Response;
use Livewire\Component;

class Review extends Component
{
    public Form $rubric;
    public Response $parent;

    public $existing = null;
    public $reviews;
    public $tracks;

    public function mount()
    {
        if ($existing = $this->findExisting()) {
            $this->existing = $existing;
            $this->reviews = $this->existing->answers;
            $this->buildTracks();
        } else {
            $this->buildFormAndTracks();
        }
    }

    public function render()
    {
        return view('livewire.galaxy.responses.review');
    }

    public function save()
    {
        if ($this->existing) {
            $this->existing->update([
                'answers' => $this->reviews,
            ]);
        } else {
            Response::create([
                'form_id' => $this->rubric->id,
                'user_id' => auth()->id(),
                'parent_id' => $this->parent->id,
                'type' => 'rubric',
                'answers' => $this->reviews,
            ]);
        }

        $this->emit('notify', ['type' => 'success', 'message' => 'Successfully saved response']);
    }

    private function buildFormAndTracks()
    {
        foreach($this->parent->answers['question-tracks'] as $track) {
            $key = strtolower(str_replace(' ', '-', $track));
            $this->reviews[$key] = [];
            $this->tracks[$key] = $track;
        }
    }

    private function buildTracks()
    {
        foreach($this->parent->answers['question-tracks'] as $track) {
            $key = strtolower(str_replace(' ', '-', $track));
            $this->tracks[$key] = $track;
        }
    }

    private function findExisting()
    {
        return Response::where('user_id', auth()->id())
            ->where('parent_id', $this->parent->id)
            ->where('form_id', $this->rubric->id)
            ->first();
    }
}
