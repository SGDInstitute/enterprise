<?php

namespace App\Livewire\App\Orders;

use App\Models\Order;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public Order $order;

    public $page;

    public function mount($page = null)
    {
        $this->authorize('view', $this->order);

        if ($this->order->user_id !== auth()->id()) {
            $this->page = 'attendee';
        } elseif ($this->order->isPaid() && $page === null) {
            $this->page = 'tickets';
        } elseif ($page === null) {
            $this->page = 'payment';
        }
    }

    public function render()
    {
        return view('livewire.app.orders.show');
    }

    public function delete()
    {
        if ($this->order->isPaid()) {
            return Notification::make()
                ->danger()
                ->title('Cannot delete a paid order')
                ->send();
        }

        $this->order->safeDelete();

        return redirect()->route('app.dashboard');
    }
}
