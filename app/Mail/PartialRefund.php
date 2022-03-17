<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartialRefund extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $order;
    public $amount;
    public $count;

    public function __construct(Order $order, $amount, $count)
    {
        $this->order = $order;
        $this->amount = $amount;
        $this->count = $count;
    }

    public function build()
    {
        return $this->markdown('mail.partial-refund')
            ->from('finance@sgdinstitute.org')
            ->subject('Partial Refund for ' . $this->order->confirmation_number . ' Processed')
            ->with([
                'amount' => $this->amount,
                'count' => $this->count,
                'order' => $this->order,
            ]);
    }
}
