<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ViewUser extends ViewRecord
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

                    session(['after_impersonation' => route('filament.admin.resources.users.view', $this->record)]);
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
            ActionGroup::make([
                Action::make('edit_information')
                    ->action(function (array $data, User $record): void {
                        if ($record->email !== $data['email']) {
                            $data['email_verified_at'] = null;
                        }
                        $record->update($data);
                        Notification::make()->title('Updated user\'s information.')->success()->send();
                    })
                    ->fillForm(fn (User $record): array => $record->attributesToArray())
                    ->form([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('pronouns')
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(table: User::class, ignorable: $this->record),
                        TextInput::make('phone')
                            ->mask('(999) 999-9999')
                            ->tel(),
                    ]),
                Action::make('change_password')
                    ->action(function (array $data, User $record) {
                        $record->update(['password' => Hash::make($data['password'])]);
                        Notification::make()->title('Updated user\'s password.')->success()->send();
                    })
                    ->form([
                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->required()
                            ->maxLength(255),
                    ]),
                Action::make('edit_address')
                    ->action(function (array $data, User $record) {
                        $record->update($data);
                        Notification::make()->title('Updated user\'s address.')->success()->send();
                    })
                    ->fillForm(fn (User $record): array => $record->attributesToArray())
                    ->form([
                        TextInput::make('address.line1'),
                        TextInput::make('address.line2'),
                        TextInput::make('address.city'),
                        TextInput::make('address.state'),
                        TextInput::make('address.zip'),
                        TextInput::make('address.country'),
                    ]),
                DeleteAction::make()->icon('heroicon-o-exclamation-triangle'),
            ]),
        ];
    }
}
