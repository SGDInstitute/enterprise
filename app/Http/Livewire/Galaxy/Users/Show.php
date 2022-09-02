<?php

namespace App\Http\Livewire\Galaxy\Users;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class Show extends Component
{
    public User $user;

    public $page;

    public $showDeleteModal = false;

    public function mount($page = 'profile')
    {
        $this->page = $page;
    }

    public function updatedPage()
    {
        return redirect()->route('galaxy.users.show', ['user' => $this->user, 'page' => $this->page]);
    }

    public function render()
    {
        return view('livewire.galaxy.users.show')
            ->layout('layouts.galaxy', ['title' => 'User '.$this->user->name])
            ->with([
                'pages' => $this->pages,
            ]);
    }

    public function getPagesProperty()
    {
        return [
            ['value' => 'profile', 'label' => 'Profile', 'href' => route('galaxy.users.show', ['user' => $this->user, 'page' => 'profile']), 'icon' => 'heroicon-o-user', 'active' => $this->page === 'profile'],
            ['value' => 'orders', 'label' => 'Orders', 'href' => route('galaxy.users.show', ['user' => $this->user, 'page' => 'orders']), 'icon' => 'heroicon-o-shopping-bag', 'active' => $this->page === 'orders'],
            ['value' => 'reservations', 'label' => 'Reservations', 'href' => route('galaxy.users.show', ['user' => $this->user, 'page' => 'reservations']), 'icon' => 'heroicon-o-shopping-cart', 'active' => $this->page === 'reservations'],
            ['value' => 'workshops', 'label' => 'Workshops', 'href' => route('galaxy.users.show', ['user' => $this->user, 'page' => 'workshops']), 'icon' => 'heroicon-o-light-bulb', 'active' => $this->page === 'workshops'],
            ['value' => 'donations', 'label' => 'Donations', 'href' => route('galaxy.users.show', ['user' => $this->user, 'page' => 'donations']), 'icon' => 'heroicon-o-gift', 'active' => $this->page === 'donations'],
        ];
    }

    public function deleteUser()
    {
        $this->user->delete();

        $this->emit('notify', ['message' => 'You\'ve deleted '.$this->user->name.'.', 'type' => 'success']);

        return redirect()->to('/galaxy/users');
    }

    public function impersonate()
    {
        activity()->on($this->user)->log('impersonated');

        session(['after_impersonation' => route('galaxy.users.show', $this->user)]);
        auth()->user()->impersonate($this->user);

        return redirect()->to('/dashboard');
    }

    public function markAsVerified()
    {
        $this->user->markEmailAsVerified();

        activity()->on($this->user)->log('verified');

        return $this->emit('notify', ['message' => 'Marked user as verified.', 'type' => 'success']);
    }

    public function resendVerification()
    {
        $this->user->sendEmailVerificationNotification();

        activity()->on($this->user)->log('email.verification');

        return $this->emit('notify', ['message' => 'Verification email resent.', 'type' => 'success']);
    }

    public function sendPasswordReset()
    {
        Password::broker()->sendResetLink(['email' => $this->user->email]);

        activity()->on($this->user)->log('emails.password_reset');

        return $this->emit('notify', ['message' => 'Password reset email sent.', 'type' => 'success']);
    }
}
