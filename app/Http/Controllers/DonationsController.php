<?php

namespace App\Http\Controllers;

use App\Billing\PaymentGateway;
use App\Donation;
use App\Exceptions\PaymentFailedException;
use App\Mail\DonationEmail;
use Illuminate\Http\Request;
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
            'company' => 'nullable|required_if:is_company,true',
            'tax_id' => 'nullable|required_if:is_company,true',
        ]);

        try {
            $charge = $this->paymentGateway->charge($data['amount'] * 100, request('stripeToken'));
            $donation = Donation::createOneTime($data, $charge);

            Mail::to(request('email'))->send(new DonationEmail($donation));
        }
        catch(PaymentFailedException $e) {
            return response()->json(['created' => false, 'message' => $e->getMessage()], 422);
        }

        return response()->json(['donation' => $donation, 'redirect' => url("/donations/{$donation->hash}")], 201);
    }
}
