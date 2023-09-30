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
    public $original;

    public function mount(): void
    {
        $this->original = auth()->user()->shifts->pluck('id');
        $this->form->fill(['shifts' => $this->original]);
    }

    public function getShiftsProperty()
    {
        return $this->event->shifts()->with('users:id')->withCount('users')->get();
    }

    public function getFilledShiftsProperty()
    {
        return $this->shifts->filter(fn ($shift) => $shift->users_count >= $shift->slots);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                CheckboxList::make('shifts')
                    ->required()
                    ->searchable()
                    ->options($this->shifts->mapWithKeys(fn ($shift) => [$shift->id => "{$shift->name}"]))
                    ->disableOptionWhen(fn (string $value): bool => $this->isOptionDisabledForUser($value))
                    ->descriptions($this->shifts->mapWithKeys(function ($shift) {
                        $person = $shift->slots === 1 ? 'person' : 'people';
                        $count = $shift->slots - $shift->users_count;

                        return [$shift->id => "{$shift->formattedDuration} - {$count} {$person} needed"];
                    }))
                    ->in(fn (CheckboxList $component): array => $component->getEnabledOptions()),
            ])
            ->statePath('data');
    }

    public function signup(): void
    {
        $selectedShifts = $this->shifts->whereIn('id', $this->form->getState()['shifts']);

        // if user unselects a shift, remove it from their shifts
        auth()->user()->shifts()->detach($this->original->diff($selectedShifts));

        // attach user to shifts selected
        $selectedShifts->each(fn ($shift) => $shift->users()->attach(auth()->user()));
    }

    public function render()
    {
        return view('livewire.app.volunteer');
    }

    private function isOptionDisabledForUser($shiftId): bool
    {
        return $this->shifts->firstWhere('id', $shiftId)->users->doesntContain(auth()->id()) && $this->filledShifts->contains($shiftId);
    }
}
