<?php

namespace App\Http\Livewire\Galaxy\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public User $user;

    public $role;

    protected $rules = [
        'user.name' => 'required',
        'user.email' => 'required|string|email|max:255|unique:users,email',
        'user.pronouns' => '',
        'role' => '',
    ];

    public function mount()
    {
        $this->user = new User();
    }

    public function render()
    {
        return view('livewire.galaxy.users.create')
            ->layout('layouts.galaxy', ['title' => 'Create User'])
            ->with([
                'roles' => $this->roles,
            ]);
    }

    public function getRolesProperty()
    {
        return Role::all()->pluck('name', 'id');
    }

    public function save()
    {
        $this->validate();

        $this->user->password = Hash::make(Str::random());
        $this->user->save();

        if ($this->role) {
            $this->user->assignRole($this->role);
        }

        return redirect()->route('galaxy.users.show', $this->user);
    }
}
