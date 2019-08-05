<?php

namespace App\Http\Controllers\Api;

use App\Billing\PaymentGateway;
use App\Donation;
use App\Exceptions\PaymentFailedException;
use App\Mail\ContributionEmail;
use App\Mail\DonationEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class DonationsController extends Controller
{
    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function store()
    {
        if (request('contributions')) {
            $contributions = request('contributions');
            $amount = 0;
            if ($contributions['sponsorship']) {
                $amount += $contributions['amount'] < $contributions['sponsorship']['amount'] ? $contributions['sponsorship']['amount'] : $contributions['amount'];
            }

            if ($contributions['vendor']) {
                $amount += $contributions['vendor']['amount'] * $contributions['vendor']['quantity'];
            }

            if ($contributions['ads']) {
                $amount += collect($contributions['ads'])->sum(function($ad) {
                    return $ad['amount'] * $ad['quantity'];
                });
            }

            $contributions['event_id'] = request('event_id');

            try {
                $charge = $this->paymentGateway->charge($amount, request('payment_token'));
                $donation = Donation::createContribution($contributions, $charge);

                Mail::to(auth()->user()->email)->send(new ContributionEmail($donation));
            } catch (PaymentFailedException $e) {
                return response()->json(['created' => false, 'message' => $e->getMessage()], 422);
            }
        }
    }
}
