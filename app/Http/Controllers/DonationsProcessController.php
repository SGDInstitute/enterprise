<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;

class DonationsProcessController extends Controller
{
    public function __invoke()
    {
        $paymentIntent = PaymentIntent::retrieve(request()->get('payment_intent'));

        Donation::where('transaction_id', $paymentIntent->id)->update(['status' => $paymentIntent->status]);

        return redirect('/dashboard/donations?thank-you=true');
    }
}
