<?php

namespace App\Filament\Resources\EventResource\Widgets;

use App\Exports\TicketAnswersExport;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class WhoNeedsWhat extends Widget implements HasActions, HasForms
{
    use InteractsWithActions;
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

    public function exportAction(): Action
    {
        return Action::make('export')
            ->form(function () {
                $keys = $this->record->ticketTypes->pluck('form')->map->pluck('id')->flatten()->unique();

                return [
                    Select::make('question')
                        ->options($keys->combine($keys)),
                    Radio::make('status')
                        ->options([
                            'paid' => 'Paid',
                            'unpaid' => 'Unpaid',
                        ]),
                ];
            })
            ->action(fn ($data) => Excel::download(
                new TicketAnswersExport($this->record, $data['question'], $data['status']),
                "{$this->record->slug}-ticket-answers-{$data['question']}.xlsx"
            ));
    }
}
