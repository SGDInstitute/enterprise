<?php

namespace App\Http\Controllers\Admin;

use App\Donation;
use App\Http\Controllers\Controller;
use Stripe\Charge;
use Stripe\Subscription;
use Facades\App\Billing\Address;
use Stripe\Customer;

class DonationsController extends Controller
{
    public function index()
    {
        return view('admin.donations.index', [
            'donations' => Donation::with('user', 'subscription')->get(),
        ]);
    }

    public function show(Donation $donation)
    {
        if ($donation->subscription !== null && $donation->subscription->isActive()) {
            $subscription = Subscription::retrieve(
                $donation->subscription->subscription_id,
                ['api_key' => getStripeSecret($donation->group)]
            );

            $customer = Customer::retrieve(
                $subscription->customer,
                ['api_key' => getStripeSecret($donation->group)]
            );

            $address = Address::format(end($customer['sources']->data));
        } elseif ($donation->receipt->transaction_id) {
            $charge = Charge::retrieve(
                $donation->receipt->transaction_id,
                ['api_key' => getStripeSecret($donation->group)]
            );

            $address = Address::format($charge['source']);
        }

        return view('admin.donations.show', compact('donation', 'charge', 'subscription', 'address'));
    }
}
