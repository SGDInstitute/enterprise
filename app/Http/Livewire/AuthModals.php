<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AuthModals extends Component
{
    public $loginModal = false;

    public $forgotModal = false;

    public $sent = false;

    public $form = [
        'email' => '',
    ];

    protected $listeners = ['showLogin'];

    public function render()
    {
        return view('livewire.auth-modals');
    }

    public function forgot()
    {
        $status = Password::sendResetLink(['email' => $this->form['email']]);

        if ($status == Password::RESET_LINK_SENT) {
            $this->sent = true;
        } else {
            throw ValidationException::withMessages([
                'form.email' => __($status),
            ]);
        }
    }

    public function login()
    {
        $data = $this->validate([
            'form.email' => 'required|string|email',
            'form.password' => 'required|string',
        ]);

        if (auth()->attempt($data['form'])) {
            request()->session()->regenerate();

            return redirect(url()->previous());
        } else {
            throw ValidationException::withMessages([
                'form.email' => __('auth.failed'),
            ]);
        }
    }

    public function showLogin($data)
    {
        $this->form['email'] = $data['email'];
        $this->loginModal = true;
    }

    public function swap($form)
    {
        $this->reset('loginModal', 'forgotModal');
        $this->$form = true;
    }
}
