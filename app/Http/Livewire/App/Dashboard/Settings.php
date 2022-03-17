<?php

namespace App\Http\Livewire\App\Dashboard;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Settings extends Component
{
    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.app.dashboard.settings');
    }

    public function save()
    {
        $this->validate();

        $this->user->save();
        $this->emit('notify', ['message' => 'Successfully saved your settings', 'type' => 'success']);
    }

    protected function rules()
    {
        return [
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user->id)],
            'user.pronouns' => [],
        ];
    }
}
