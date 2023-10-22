<?php

namespace App\Filament\Resources\EventResource\Widgets;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class WhoNeedsWhat extends Widget
{
    protected static string $view = 'filament.resources.event-resource.widgets.who-needs-what';

    public ?Model $record = null;

    public $question = '';
    public $option = '';

    public $options = [];

    public $report = [];

    protected function getViewData(): array
    {
        return [
            'questions' => $this->questions,
        ];
    }

    public function getQuestionsProperty()
    {
        return $this->record->ticketTypes->flatMap->form->unique('id');
    }

    public function updatedQuestion()
    {
        if ($this->questions->firstWhere('id', $this->question)['type'] === 'list') {
            $this->options = $this->questions->firstWhere('id', $this->question)['options'];
        }
    }

    public function run()
    {
        $this->report = $this->record->tickets()
            ->whereJsonContains("answers->{$this->question}", $this->option)
            ->with('user')
            ->get();
    }
}
