<?php

namespace App\Http\Controllers;

use App\Billing\PaymentGateway;
use App\Donation;
use App\Exceptions\PaymentFailedException;
use App\Exceptions\SubscriptionFailedException;
use App\Mail\DonationEmail;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Stripe\Subscription;

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
            'group' => 'required',
            'company' => 'nullable|required_if:is_company,true',
            'tax_id' => 'nullable|required_if:is_company,true',
        ]);

        try {
            if ($data['subscription'] === 'no') {
                $charge = $this->paymentGateway->charge($data['amount'] * 100, request('stripeToken'));
                $donation = Donation::createOneTime($data, $charge);
            } else {
                if (!request()->user()->isCustomer(request()->group)) {
                    request()->user()->createCustomer(request()->group, request()->stripeToken);
                }

                $subscription = $this->paymentGateway->subscribe("{$data['subscription']}-{$data['amount']}", request()->user()->institute_stripe_id);
                $donation = Donation::createWithSubscription($data, $subscription);
            }

            Mail::to(request('email'))->send(new DonationEmail($donation));
        } catch (PaymentFailedException $e) {
            return response()->json(['created' => false, 'message' => $e->getMessage()], 422);
        } catch (SubscriptionFailedException $e) {
            return response()->json(['created' => false, 'message' => $e->getMessage()], 422);
        }

        return response()->json(['donation' => $donation, 'redirect' => url("/donations/{$donation->hash}")], 201);
    }

    public function show($hash)
    {
        $donation = Donation::findByHash($hash);

        if ($donation->subscription !== null && $donation->subscription->isActive()) {
            $subscription = Subscription::retrieve(
                $donation->subscription->subscription_id,
                ['api_key' => getStripeSecret($donation->group)]);
        } elseif($donation->charge_id) {
            $charge = Charge::retrieve(
                $donation->charge_id,
                ['api_key' => getStripeSecret($donation->group)]);
        }

        return view('donations.show', compact('donation', 'charge', 'subscription'));
    }
}
