<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Password;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('send_password_reset')
                ->icon('heroicon-o-paper-airplane')
                ->color('gray')
                ->action(function () {
                    Password::broker()->sendResetLink(['email' => $this->record->email]);

                    activity()->on($this->record)->log('emails.password_reset');

                    Notification::make()->title('Password reset email sent.')->success()->send();
                }),
            Action::make('impersonate')
                ->icon('heroicon-o-bolt')
                ->color('gray')
                ->action(function () {
                    activity()->on($this->record)->log('impersonated');

                    session(['after_impersonation' => route('filament.resources.users.edit', $this->record)]);
                    auth()->user()->impersonate($this->record);

                    return redirect()->to('/dashboard');
                }),
            Action::make('manually_verify_user')
                ->color('gray')
                ->icon('heroicon-o-shield-check')
                ->hidden($this->record->hasVerifiedEmail())
                ->action(function () {
                    $this->record->markEmailAsVerified();

                    activity()->on($this->record)->log('verified');

                    Notification::make()->title('Marked user as verified.')->success()->send();
                }),
            DeleteAction::make()->icon('heroicon-o-exclamation-triangle'),
        ];
    }
}
