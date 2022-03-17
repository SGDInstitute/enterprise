<?php

namespace App\Http\Livewire\App\Orders;

use App\Models\Order;
use Barryvdh\DomPDF\Facade as PDF;
use Livewire\Component;

class Show extends Component
{
    public Order $order;
    public $showCheckModal = false;
    public $showInvoiceModal = false;

    protected $rules = [
        'order.invoice.billable' => '',
    ];

    public function render()
    {
        return view('livewire.app.orders.show')
            ->with([
                'filledCount' => $this->filledCount,
                'subtotal' => $this->order->subtotal,
                'progressSteps' => $this->progressSteps,
                'progressCurrent' => $this->progressSteps->firstWhere('complete', false),
                'userIsOwner' => $this->userIsOwner,
            ]);
    }

    // Properties

    public function getFilledCountProperty()
    {
        return $this->order->tickets->filter(fn($ticket) => $ticket->isFilled())->count();
    }

    public function getProgressStepsProperty()
    {
        return collect([
            ['name' => 'Create Reservation', 'complete' => true],
            ['name' => 'Pay', 'complete' => $this->order->isPaid(), 'help' => 'app.help.pay'],
            ['name' => 'Add Folks to Tickets', 'complete' => $this->order->isFilled(), 'help' => 'app.help.tickets'],
            ['name' => 'Check in', 'complete' => $this->checkinComplete(), 'available' => $this->order->event->settings->get('allow_checkin', false), 'help' => 'app.help.checkin', 'link' => $this->checkinLink()],
        ]);
    }

    public function getUserIsOwnerProperty()
    {
        return auth()->id() === $this->order->user_id;
    }

    // Methods

    public function createInvoice()
    {
        $this->order->generateInvoice();
        $this->showInvoiceModal = true;
    }

    public function checkinComplete()
    {
        if ($this->order->tickets->firstWhere('user_id', auth()->id()) !== null) {
            return $this->order->tickets->firstWhere('user_id', auth()->id())->isQueued();
        }

        return false;
    }

    public function checkinLink()
    {
        if ($this->order->tickets->firstWhere('user_id', auth()->id()) !== null) {
            $ticket = $this->order->tickets->firstWhere('user_id', auth()->id());

            return route('app.checkin', $ticket);
        }
    }

    public function delete()
    {
        $this->order->tickets->each->delete();
        $this->order->delete();
        return redirect('/');
    }

    public function downloadInvoice()
    {
        $this->saveInvoice();

        $pdf = PDF::loadView('pdf.invoice', ['order' => $this->order])->output();
        $filename = 'Invoice-' . $this->order->formattedId . '.pdf';
        return response()->streamDownload(fn() => print($pdf), $filename);
    }

    public function downloadW9()
    {
        return response()->download(public_path('documents/SGD-Institute-W9.pdf'));
    }

    public function saveInvoice()
    {
        $this->order->save();
        $this->emit('notify', ['message' => 'Successfully saved invoice details.', 'type' => 'success']);
    }
}
