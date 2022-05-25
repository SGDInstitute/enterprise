<?php

namespace App\Http\Livewire\Galaxy\Responses;

use App\Models\Form;
use App\Models\Response;
use Livewire\Component;

class Review extends Component
{
    public Form $reviewForm;
    public Response $parent;

    public $answers;

    public function mount()
    {
        if ($this->existing) {
            $this->answers = $this->existing->answers;
        } else {
            $this->answers = $this->setUpResponseForm($this->reviewForm);
        }
    }

    public function render()
    {
        return view('livewire.galaxy.responses.review', [
            'fillable' => $this->fillable,
        ]);
    }

    public function getExistingProperty()
    {
        return Response::where('user_id', auth()->id())
            ->where('parent_id', $this->parent->id)
            ->where('form_id', $this->reviewForm->id)
            ->first();
    }

    public function getFillableProperty()
    {
        return $this->reviewForm->auth_required ? auth()->check() : true;
    }

    public function isVisible($item)
    {
        if (isset($item['visibility']) && isset($item['conditions']) && $item['visibility'] === 'conditional' && count($item['conditions']) > 0) {
            [$passes, $fails] = collect($item['conditions'])->partition(function ($condition) {
                if ($condition['method'] === 'equals') {
                    return $this->answers[$condition['field']] == $condition['value'];
                } elseif ($condition['method'] === 'not') {
                    return $this->answers[$condition['field']] != $condition['value'];
                } elseif ($condition['method'] === '>') {
                    return $this->answers[$condition['field']] > $condition['value'];
                } elseif ($condition['method'] === '>=') {
                    return $this->answers[$condition['field']] >= $condition['value'];
                } elseif ($condition['method'] === '<') {
                    return $this->answers[$condition['field']] < $condition['value'];
                } elseif ($condition['method'] === '<=') {
                    return $this->answers[$condition['field']] <= $condition['value'];
                }
            });

            if (isset($item['visibility-andor']) && $item['visibility-andor'] === 'or') {
                return $passes->count() > 0;
            } else {
                return $fails->count() === 0;
            }
        }

        return true;
    }

    public function save()
    {
        if($this->existing) {
            $this->existing->update([
                'answers' => $this->answers,
            ]);

            return $this->emit('notify', ['message' => 'Successfully updated.', 'type' => 'success']);
        }

        $this->existing = Response::create([
            'user_id' => auth()->id(),
            'parent_id' => $this->parent->id,
            'type' => $this->reviewForm->type,
            'form_id' => $this->reviewForm->id,
            'answers' => $this->answers,
        ]);

        $this->emit('notify', ['message' => 'Successfully saved review. You can leave this page and come back to edit your responses.', 'type' => 'success']);
    }

    private function setUpResponseForm($form)
    {
        return $form->form
            ->filter(fn ($item) => $item['style'] === 'question')
            ->mapWithKeys(function ($item) {
                if ($item['type'] === 'list' && $item['list-style'] === 'checkbox') {
                    return [$item['id'] => []];
                }

                return [$item['id'] => ''];
            })->toArray();
    }
}
