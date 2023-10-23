<?php

namespace App\Filament\Resources\EventResource\Widgets;

use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class WhoNeedsWhat extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.resources.event-resource.widgets.who-needs-what';

    public ?Model $record = null;
    public ?array $data = [];

    public bool $hasRun = false;
    public $report = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        $questions = $this->record->ticketTypes->flatMap->form->unique('id');

        return $form
            ->columns(2)
            ->schema([
                Select::make('question')
                    ->options($questions->pluck('question', 'id'))
                    ->required()
                    ->live(),
                Select::make('option')
                    ->options(function (Get $get) use ($questions): array {
                        if ($get('question') === null) {
                            return [];
                        }
                        $options = $questions->firstWhere('id', $get('question'))['options'];

                        return array_combine($options, $options);
                    })
                    ->required()
                    ->multiple(),
            ])
            ->statePath('data');
    }

    public function run()
    {
        $this->hasRun = true;
        $data = $this->form->getState();

        $this->report = $this->record->tickets()
            ->whereJsonContains("answers->{$data['question']}", $data['option'])
            ->with('user')
            ->get();
    }
}
