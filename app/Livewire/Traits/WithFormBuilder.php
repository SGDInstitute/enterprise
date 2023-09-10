<?php

namespace App\Livewire\Traits;

trait WithFormBuilder
{
    // Required Params
    // public $form;
    // public $openIndex = -1;
    // public $showSettings = false;

    public function getFieldsProperty()
    {
        if (empty($this->form)) {
            return [];
        }

        return $this->form->filter(fn ($item) => $item['style'] === 'question')->map(fn ($question) => $question['id']);
    }

    public function getTypeOptionsProperty()
    {
        return [
            'text' => 'Text',
            'number' => 'Number',
            'textarea' => 'Textarea',
            'list' => 'List',
            'matrix' => 'Matrix',
            'opinion-scale' => 'Opinion Scale',
        ];
    }

    public function addCondition()
    {
        $question = $this->form[$this->openIndex];
        $question['conditions'][] = ['field' => '', 'method' => '', 'value' => ''];
        $this->form[$this->openIndex] = $question;
    }

    public function addContent()
    {
        $this->form[] = ['style' => 'content', 'id' => 'content-', 'content' => ''];
        $this->openIndex = count($this->form) - 1;
    }

    public function addCollaborators()
    {
        $this->form[] = ['style' => 'collaborators', 'id' => 'collaborators'];
        $this->openIndex = count($this->form) - 1;
    }

    public function addQuestion()
    {
        $this->form[] = ['style' => 'question', 'id' => 'question-', 'question' => '', 'type' => '', 'rules' => ''];
        $this->openIndex = count($this->form) - 1;
    }

    public function delete($index)
    {
        unset($this->form[$index]);
        $this->form = $this->form->values();
    }

    public function duplicate($index)
    {
        $this->form[] = $this->form[$index];
    }

    public function moveDown($index)
    {
        if ($index !== 0) {
            $original = $this->form[$index];
            $below = $this->form[$index + 1];

            $this->form[$index] = $below;
            $this->form[$index + 1] = $original;
        }
    }

    public function moveUp($index)
    {
        if ($index !== 0) {
            $original = $this->form[$index];
            $above = $this->form[$index - 1];

            $this->form[$index] = $above;
            $this->form[$index - 1] = $original;
        }
    }

    public function openSettings($index)
    {
        if ($this->openIndex !== $index) {
            //whoops;
        }
        $this->showSettings = true;
    }

    public function setOpenIndex($index)
    {
        $this->openIndex = $index;
    }

    public function removeCondition($index)
    {
        $question = $this->form[$this->openIndex];
        unset($question['conditions'][$index]);
        $this->form[$this->openIndex] = $question;
    }
}
