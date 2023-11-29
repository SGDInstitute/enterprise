<?php

namespace App\Livewire\Galaxy;

use App\Livewire\Traits\WithFiltering;
use App\Livewire\Traits\WithSorting;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithFiltering;
    use WithPagination;
    use WithSorting;

    public $filters = [
        'search' => '',
    ];

    public $perPage = 25;

    public function render()
    {
        return view('livewire.galaxy.users')
            ->layout('layouts.galaxy', ['title' => 'Users'])
            ->with([
                'users' => $this->users,
            ]);
    }

    // Properties

    public function getUsersProperty()
    {
        return User::query()
            ->when($this->filters['search'], function ($query) {
                $query->where(function ($query) {
                    $search = trim($this->filters['search']);
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('id', $search);
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    // Methods

    public function impersonate($id)
    {
        $user = $this->users->find($id);
        session(['after_impersonation' => route('galaxy.users.show', $user)]);
        auth()->user()->impersonate($user);

        return redirect()->to('/dashboard');
    }
}
