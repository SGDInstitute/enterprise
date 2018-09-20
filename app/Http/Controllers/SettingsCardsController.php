<?php

namespace App\Http\Controllers;

use App\Notifications\UpdatedCard;
use Illuminate\Http\Request;

class SettingsCardsController extends Controller
{
    public function __invoke()
    {
        $data = request()->validate([
            'payment_token' => 'required',
            'account' => 'required',
        ]);

        $customerId = auth()->user()->{$data['account']."_stripe_id"};
        $apiKey = config("{$data['account']}.stripe.secret");

        try {
            $cu = \Stripe\Customer::retrieve($customerId, ['api_key' => $apiKey]);
            $cu->source = $data['payment_token'];
            $cu->save();

            $customer = \Stripe\Customer::retrieve($customerId, ['api_key' => $apiKey]);
            $card = collect($customer->sources['data'])->firstWhere('id', $customer->default_source);

            request()->user()->notify(new UpdatedCard($card));
            return response()->json(['data' => ['card_last_four' => $card->last4]]);
        } catch (\Stripe\Error\InvalidRequest $e) {
            $body = $e->getJsonBody();
            $err = $body['error'];
            $error = $err['message'];

            return response()->json(['error' => $error], 422);
        }
    }
}
