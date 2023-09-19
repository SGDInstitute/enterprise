<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Stripe\StripeClient;
use Stripe\Subscription as StripeSubscription;

class StripeWebhookController extends Controller
{
    // public function __construct()
    // {
    //     if (config('cashier.webhook.secret')) {
    //         $this->middleware(VerifyWebhookSignature::class);
    //     }
    // }

    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $method = 'handle' . Str::studly(str_replace('.', '_', $payload['type']));

        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            return $response;
        }

        return $this->missingMethod($method, $payload);
    }

    public function handleCustomerSubscriptionUpdated($payload)
    {
        if ($donation = $this->getDonationBySubscriptionId($payload['data']['object']['id'])) {
            $data = $payload['data']['object'];

            if (isset($data['status']) && $data['status'] === StripeSubscription::STATUS_INCOMPLETE_EXPIRED) {
                $donation->delete();

                return;
            }

            $firstItem = $data['items']['data'][0];

            $donation->amount = $firstItem['plan']['amount'] ?? $firstItem['plan']['price']['unit_amount'];

            // Cancellation date...
            if (isset($data['cancel_at_period_end'])) {
                if ($data['cancel_at_period_end']) {
                    $donation->ends_at = Carbon::createFromTimestamp($data['current_period_end']);
                } elseif (isset($data['cancel_at'])) {
                    $donation->ends_at = Carbon::createFromTimestamp($data['cancel_at']);
                } else {
                    $donation->ends_at = null;
                }
            }

            // Status...
            if (isset($data['status'])) {
                $donation->status = $data['status'] === 'active' ? 'successful' : $data['status'];
            }

            $donation->save();
        }
    }

    public function handleCheckoutSessionCompleted($payload)
    {
        $orderId = $payload['data']['object']['metadata']['order_id'];
        $order = Order::find($orderId);

        $order->markAsPaid($payload['data']['object']['payment_intent'], $payload['data']['object']['amount_total']);
    }

    public function handleInvoicePaymentSucceeded($payload)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $object = $payload['data']['object'];

        if ($object['billing_reason'] === 'subscription_create') {
            $subscription_id = $object['subscription'];
            $payment_intent_id = $object['payment_intent'];

            $payment_intent = $stripe->paymentIntents->retrieve($payment_intent_id, []);

            $stripe->subscriptions->update($subscription_id, ['default_payment_method' => $payment_intent->payment_method]);
        }
    }

    protected function missingMethod($method, $parameters = [])
    {
        return new Response;
    }

    private function getDonationBySubscriptionId($id)
    {
        return Donation::firstWhere('subscription_id', $id);
    }
}
