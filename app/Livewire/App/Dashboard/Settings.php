<?php

namespace App\Livewire\App\Dashboard;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class Settings extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $profile = [];
    public ?array $password = [];

    public function mount()
    {
        $this->profileForm->fill(auth()->user()->only(['name', 'email', 'pronouns', 'phone']));
        $this->passwordForm->fill();
    }

    public function profileForm(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->unique(table: User::class, ignorable: auth()->user())
                    ->required(),
                TextInput::make('pronouns')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->mask('(999) 999-9999'),
            ])
            ->statePath('profile');
    }

    public function passwordForm(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('current_password')
                    ->required()
                    ->password()
                    ->rules(['current_password']),
                TextInput::make('password')
                    ->password()
                    ->rules(['required', Password::defaults(), 'confirmed']),
                TextInput::make('password_confirmation')
                    ->password()
                    ->required(),
            ])
            ->statePath('password');
    }

    public function render()
    {
        return view('livewire.app.dashboard.settings');
    }

    public function saveProfile()
    {
        $data = $this->profileForm->getState();

        if (auth()->user()->email !== $data['email']) {
            $data['email_verified_at'] = null;
        }

        auth()->user()->update($data);

        Notification::make()
            ->success()
            ->title('Successfully saved your settings')
            ->send();
    }

    public function savePassword()
    {
        $data = $this->passwordForm->getState();

        auth()->user()->update([
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function getForms(): array
    {
        return [
            'profileForm',
            'passwordForm',
        ];
    }
}
