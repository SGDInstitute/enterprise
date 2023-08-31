<?php

namespace App\Livewire\Galaxy\Builder;

use App\Livewire\Traits\WithFormBuilder;
use Livewire\Component;

class Form extends Component
{
    use WithFormBuilder;

    public $form;

    public $model;

    public $openIndex = -1;

    public $showSettings = false;

    public $searchable = [];

    public $rules = [
        'searchable' => '',
        'form' => 'required',
    ];

    public function render()
    {
        return view('livewire.galaxy.builder.form')
            ->with([
                'fields' => $this->fields,
                'typeOptions' => $this->typeOptions,
                'searchableFields' => $this->searchableFields,
            ]);
    }

    public function getSearchableFieldsProperty()
    {
        return collect($this->form)
            ->filter(fn ($question) => $question['style'] === 'question')
            ->filter(fn ($question) => $question['type'] !== 'textarea')
            ->pluck('question', 'id');
    }

    public function save()
    {
        // validate
        if ($this->form !== []) {
            if (! is_array($this->form)) {
                $form = $this->form->toArray();
            } else {
                $form = $this->form;
            }

            foreach ($form as $index => $item) {
                if ($item['style'] === 'question' && ($item['type'] === 'list' || $item['type'] === 'matrix') && is_string($item['options'])) {
                    $form[$index]['options'] = explode(',', preg_replace("/((\r?\n)|(\r\n?))/", ',', $item['options']));
                }
                if ($item['style'] === 'question' && $item['type'] === 'matrix' && is_string($item['scale'])) {
                    $form[$index]['scale'] = explode(',', preg_replace("/((\r?\n)|(\r\n?))/", ',', $item['scale']));
                }
            }
            $this->model->form = $form;
        }

        $this->model->save();
        $this->dispatch('notify', ['message' => 'Saved form', 'type' => 'success']);
    }
}
