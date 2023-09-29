<?php

namespace App\Livewire\App;

use App\Models\Event;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class Volunteer extends Component implements HasForms
{
    use InteractsWithForms;

    public Event $event;

    public ?array $data = [];
    public ?array $original = [];

    public function mount(): void
    {
        $this->original = auth()->user()->shifts->pluck('id');
        $this->form->fill(['shifts' => $this->original]);
    }

    public function getShiftsProperty()
    {
        return $this->event->shifts;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                CheckboxList::make('shifts')
                    ->options($this->shifts->mapWithKeys(fn ($shift) => [$shift->id => "{$shift->name}"]))
                    ->descriptions($this->shifts->mapWithKeys(function ($shift) {
                        $person = $shift->slots === 1 ? 'person' : 'people';
                        return [$shift->id => "{$shift->formattedDuration} - {$shift->slots} {$person} needed"];
                    }))
                    ->searchable(),
            ])
            ->statePath('data');
    }

    public function signup(): void
    {
        // if user unselects need to remove it from thier shifts
        $selectedShifts = $this->shifts->whereIn('id', $this->form->getState()['shifts']);
        $selectedShifts->each(fn ($shift) => $shift->users()->attach(auth()->user()));
    }

    public function render()
    {
        return view('livewire.app.volunteer');
    }
}
