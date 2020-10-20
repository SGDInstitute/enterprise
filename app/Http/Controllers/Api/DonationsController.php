<?php

namespace App\Http\Controllers\Api;

use App\Billing\PaymentGateway;
use App\Models\Donation;
use App\Models\Event;
use App\Exceptions\PaymentFailedException;
use App\Http\Controllers\Controller;
use App\Mail\ContributionEmail;
use App\Mail\DonationEmail;
use Illuminate\Http\Request;
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
                $amount += collect($contributions['ads'])->sum(function ($ad) {
                    return $ad['amount'] * $ad['quantity'];
                });
            }

            try {
                if (request('event_id')) {
                    $contributions['event_id'] = request('event_id');
                    $event = Event::find(request('event_id'));
                    $this->paymentGateway->setApiKey($event->getSecretKey());

                    $charge = $this->paymentGateway->charge($amount, request('payment_token'));
                    $donation = Donation::createContribution($contributions, $charge, $event->stripe);
                } else {
                    $this->paymentGateway->setApiKey(getStripeSecret('sgdinstitute'));

                    $charge = $this->paymentGateway->charge($amount, request('payment_token'));
                    $donation = Donation::createContribution($contributions, $charge, 'sgdinstitute');
                }

                Mail::to(auth()->user()->email)->send(new ContributionEmail($donation));

                return response()->json(['created' => true, 'message' => 'Successfully created contribution.', 'url' => url("/donations/{$donation->hash}")], 201);
            } catch (PaymentFailedException $e) {
                return response()->json(['created' => false, 'message' => $e->getMessage()], 422);
            }
        }
    }
}
