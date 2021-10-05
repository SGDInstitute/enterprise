<?php

namespace App\Http\Livewire\Galaxy\Users;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Profile extends Component
{
    public User $user;

    public $profileChanged;
    public $passwordChanged;

    public $newRole = '';
    public $password;
    public $password_confirmation;

    protected function rules() {
        return [
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user->id)],
        ];
    }

    public function updating($field, $value)
    {
        $profileFields = ['user.name', 'user.email', 'user.username', 'user.allow_notifications'];
        if (in_array($field, $profileFields)) {
            $this->profileChanged = true;
        }

        $passwordFields = ['password', 'password_confirmation'];
        if (in_array($field, $passwordFields)) {
            $this->passwordChanged = true;
        }
    }

    public function render()
    {
        return view('livewire.galaxy.users.profile', [
            'roles' => Role::all()->pluck('name', 'id'),
            'userRoles' => $this->user->roles,
        ]);
    }

    public function addRole()
    {
        $this->user->assignRole($this->newRole);
        $this->reset('newRole');

        activity()->performedOn($this->user)->withProperties(['role' => $this->newRole])->log('added.role');
        return $this->emit('notify', ['message' => 'Added role.', 'type' => 'success']);
    }

    public function newPassword()
    {
        $data = $this->validate([
            'password' => 'filled|confirmed',
        ]);

        $data['password'] = bcrypt($data['password']);

        $this->user->update($data);

        activity()->performedOn(auth()->user())->log('updated.password');
        $this->reset('password', 'password_confirmation', 'passwordChanged');

        return $this->emit('notify', ['message' => 'Saved new password.', 'type' => 'success']);
    }

    public function removeRole($role)
    {
        $this->user->removeRole($role);
        activity()->performedOn($this->user)->withProperties(['role' => $this->newRole])->log('removed.role');
        return $this->emit('notify', ['message' => 'Removed role.', 'type' => 'success']);
    }

    public function save()
    {
        $this->validate();

        $this->user->save();
        $this->profileChanged = false;
        return $this->emit('notify', ['message' => 'Saved user.', 'type' => 'success']);
    }
}
