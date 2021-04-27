<?php

namespace App\Http\Livewire\App\Orders;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

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
            ['name' => 'Get Ready', 'complete' => false],
        ]);
    }

    // Methods

    public function createInvoice()
    {
        $this->order->generateInvoice();
        $this->showInvoiceModal = true;
    }

    public function delete()
    {
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
