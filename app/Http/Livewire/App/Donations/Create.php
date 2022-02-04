<?php

namespace App\Http\Livewire\App\Donations;

use App\Models\Donation;
use App\Models\DonationPlan as Plan;
use App\Models\DonationPrice as Price;
use App\Models\User;
use Livewire\Component;
use NumberFormatter;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class Create extends Component
{
    public $clientSecret;
    public $donation;
    public $otherAmount = false;
    public $form = [
        'type' => 'monthly',
        'amount' => '',
        'name' => '',
        'email' => '',
    ];
    public $newUser;
    public $step = 1;

    public $oneTimeOptions = [10,20,50,100];
    public $monthlyOptions = [5,10,20,25,50,100];

    public $rules = [
        'form.type' => 'required',
        'form.amount' => 'required',
    ];

    protected $messages = [
        'form.type.required' => 'Please select a one-time or monthly donation.',
        'form.amount.required' => 'Please select an amount to donate before continuing.',
    ];

    public function updatedFormEmail($value)
    {
        $user = User::firstWhere('email', $value);

        if(!$user && auth()->check()) {
            $this->emit('notify', ['message' => 'Looks like the email entered does not match the email that is logged in.', 'type' => 'error']);
        } elseif(!$user) {
            $this->emit('notify', ['message' => 'No user with that email was found, we will create one for you.', 'type' => 'info']);
        } elseif($user && !auth()->check()) {
            $this->emit('notify', ['message' => 'Please login', 'type' => 'error']);
        }
    }

    public function mount()
    {
        if(auth()->check()) {
            $this->form['name'] = auth()->user()->name;
            $this->form['email'] = auth()->user()->email;
        }
    }

    public function render()
    {
        return view('livewire.app.donations.create')
            ->with([
                'amountLabel' => $this->amountLabel,
                'checkoutButton' => $this->checkoutButton,
                'prices' => $this->prices,
            ]);
    }

    // Properties

    public function getAmountLabelProperty()
    {
        if($this->form['amount'] != '') {
            return '$' . $this->form['amount'] . ' ';
        }
    }

    public function getCheckoutButtonProperty()
    {
        if($this->donation !== null && $this->donation->type === 'one-time') {
            return auth()->user()->checkoutCharge($this->donation->amount, 'One Time Donation', 1, [
                'success_url' => route('app.donations.show', ['donation' => $this->donation, 'success']),
                'cancel_url' => route('app.donations.create', ['donation' => $this->donation, 'canceled']),
                'billing_address_collection' => 'required',
                'metadata' => [
                    'user_id' => auth()->id(),
                    'donation_id' => $this->donation->id,
                ]
            ]);
        } elseif($this->donation !== null && $this->donation->type === 'monthly') {
            return auth()->user()
                ->newSubscription('fan-monthly', 'price_1K86dlI7BmcylBPU02nCkIOH')
                ->checkout([
                    'success_url' => route('app.dashboard'),
                    'cancel_url' => route('app.dashboard'),
                    'billing_address_collection' => 'required',
                    'metadata' => [
                        'user_id' => auth()->id(),
                        'donation_id' => $this->donation->id,
                    ]
                ]);
        }
    }

    public function getPlanProperty()
    {
        return Plan::find(1);
    }

    public function getPricesProperty()
    {
        return Price::where('plan_id', 1)->get();
    }

    // Methods

    public function chooseAmount($amount)
    {
        $this->form['amount'] = $amount;
        if($this->form['type'] === 'one-time' && $this->otherAmount) {
            $this->otherAmount = false;
        }
    }

    public function chooseOther()
    {
        $this->otherAmount = true;
        $this->form['amount'] = '';
    }

    public function startPayment()
    {
        $this->validate();

        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentIntent = PaymentIntent::create([
            'amount' => $this->form['amount'] * 100,
            'currency' => 'usd',
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        $this->clientSecret = $paymentIntent->client_secret;

        $this->step = 2;
    }
}
