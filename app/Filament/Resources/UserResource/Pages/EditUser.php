<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Password;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('send_password_reset')
                ->action(function () {
                    Password::broker()->sendResetLink(['email' => $this->record->email]);

                    activity()->on($this->record)->log('emails.password_reset');

                    Notification::make()->title('Password reset email sent.')->success()->send();
                }),
            Action::make('impersonate')
                ->action(function () {
                    activity()->on($this->record)->log('impersonated');

                    session(['after_impersonation' => route('filament.resources.users.edit', $this->record)]);
                    auth()->user()->impersonate($this->record);

                    return redirect()->to('/dashboard');
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
