<?php

namespace App\Http\Controllers;

use App\Billing\PaymentGateway;
use App\Donation;
use App\Exceptions\PaymentFailedException;
use App\Mail\DonationEmail;
use Illuminate\Support\Facades\Mail;

class DonationsController extends Controller
{
    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function create()
    {
        return view('donations.create');
    }

    public function store()
    {
        $data = request()->validate([
            'amount' => 'required|numeric|between:5,999999',
            'name' => 'required',
            'email' => 'required',
            'subscription' => 'required',
            'company' => 'nullable|required_if:is_company,true',
            'tax_id' => 'nullable|required_if:is_company,true',
        ]);

        try {
            if ($data['subscription'] === 'no') {
                $charge = $this->paymentGateway->charge($data['amount'] * 100, request('stripeToken'));
                $donation = Donation::createOneTime($data, $charge);
            } else {
                $subscription = $this->paymentGateway->subscribe("{$data['subscription']}-{$data['amount']}", request()->user()->institute_stripe_id);
                $donation = Donation::createWithSubscription($data, $subscription);
            }

            Mail::to(request('email'))->send(new DonationEmail($donation));
        } catch (PaymentFailedException $e) {
            return response()->json(['created' => false, 'message' => $e->getMessage()], 422);
        }

        return response()->json(['donation' => $donation, 'redirect' => url("/donations/{$donation->hash}")], 201);
    }
}
