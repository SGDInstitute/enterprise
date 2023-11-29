<?php

namespace App\Livewire\Galaxy;

use App\Livewire\Traits\WithFiltering;
use App\Livewire\Traits\WithSorting;
use App\Models\Donation;
use Livewire\Component;
use Livewire\WithPagination;

class Donations extends Component
{
    use WithFiltering;
    use WithPagination;
    use WithSorting;

    public $user;

    public $filters = [
        'search' => '',
    ];

    public $selectAll = false;

    public $selectPage = false;

    public $selected = [];

    public $showPartialModal = false;

    public $perPage = 25;

    public function render()
    {
        return view('livewire.galaxy.donations')
            ->layout('layouts.galaxy', ['title' => 'Donations'])
            ->with([
                'donations' => $this->donations,
            ]);
    }

    public function getDonationsProperty()
    {
        return Donation::join('users', 'donations.user_id', '=', 'users.id')
            ->when($this->user, function ($query) {
                $query->forUser($this->user);
            })
            ->when($this->filters['search'], function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $search = trim($search);
                    $query->where('users.email', 'like', '%' . $search . '%')
                        ->orWhere('donations.subscription_id', 'like', '%' . $search . '%')
                        ->orWhere('donations.transaction_id', 'like', '%' . $search . '%')
                        ->orWhere('donations.amount', 'like', '%' . $search . '%')
                        ->orWhere('users.name', 'like', '%' . $search . '%')
                        ->orWhere('donations.id', $search);
                });
            })
            ->select('donations.*', 'users.name', 'users.email')
            ->with('user')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }
}
