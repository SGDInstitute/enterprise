<?php

namespace App\Livewire\App;

use App\Events\ShiftsFellBelowLimit;
use App\Models\Event;
use App\Notifications\SignedUpForShift;
use Facades\App\Actions\GenerateCompedOrder;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
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
                    ->searchable()
                    ->options($this->shifts->mapWithKeys(fn ($shift) => [$shift->id => "{$shift->name}"]))
                    ->descriptions($this->shifts->mapWithKeys(function ($shift) {
                        $person = $shift->slots === 1 ? 'person' : 'people';
                        $count = $shift->slots - $shift->users_count;

                        return [$shift->id => "{$shift->formattedDuration} - {$count} {$person} needed"];
                    }))
                    ->disableOptionWhen(fn (string $value): bool => $this->isOptionDisabled($value)),
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

        Notification::make()->success()->title('Successfully saved shifts')->send();

        $shiftsCount = auth()->user()->shifts()->where('event_id', $this->event->id)->count();
        if ($shiftsCount >= 2 && ! auth()->user()->hasCompedTicketFor($this->event)) {
            GenerateCompedOrder::volunteer(
                $this->event,
                auth()->user()
            );
            Notification::make()->success()->title('Generated comped order')->send();
        } elseif ($shiftsCount < 2 && auth()->user()->hasCompedTicketFor($this->event)) {
            ShiftsFellBelowLimit::dispatch($this->event, auth()->user());

            Notification::make()->success()->title('Removed comped order')->send();
        }
        auth()->user()->notify(new SignedUpForShift($this->event));
    }

    public function render()
    {
        return view('livewire.app.volunteer');
    }

    private function isOptionDisabled($value): bool
    {
        return $this->filledShifts->contains($value) && $this->filledShifts->firstWhere('id', $value)->users->doesntContain(auth()->id());
    }
}
