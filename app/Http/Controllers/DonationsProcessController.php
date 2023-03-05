<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Donation;
use App\Notifications\DonationReceipt;
use Stripe\PaymentIntent;

class DonationsProcessController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $paymentIntent = PaymentIntent::retrieve(request('payment_intent'));

        $donation = Donation::firstWhere('transaction_id', $paymentIntent->id);

        $donation->update(['status' => $paymentIntent->status]);
        $donation->user->notify(new DonationReceipt($donation));

        return redirect('/dashboard/donations?thank-you=true');
    }
}
