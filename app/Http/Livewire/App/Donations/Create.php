<?php

namespace App\Http\Livewire\App\Donations;

use App\Models\Donation;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Stripe\PaymentIntent;
use Stripe\Subscription;

class Create extends Component
{
    protected $listeners = ['refresh' => '$refresh'];

    public $type = 'monthly';
    public $amount = '';
    public $name = '';
    public $email = '';
    public $address = [
        'line1' => '',
        'line2' => '',
        'city' => '',
        'state' => '',
        'zip' => '',
        'country' => '',
    ];

    public $clientSecret;
    public $donation;
    public $hasLogin = false;
    public $newUser = null;
    public $otherAmount = false;
    public $step = 1;

    public $title;
    public $image;
    public $content;
    public $oneTimeOptions;
    public $monthlyOptions;

    public $rules = [
        'type' => 'required',
        'amount' => 'required',
    ];

    protected $messages = [
        'type.required' => 'Please select a one-time or monthly donation.',
        'amount.required' => 'Please select an amount to donate before continuing.',
    ];

    protected $queryString = [
        'type' => ['except' => 'monthly'],
        'name' => ['except' => ''],
        'email' => ['except' => ''],
    ];

    public function mount()
    {
        if (auth()->check()) {
            $this->name = auth()->user()->name;
            $this->email = auth()->user()->email;
            if (auth()->user()->address) {
                $this->address = auth()->user()->address;
            }
        }

        $settings = Setting::where('group', 'donations.page')->get();
        $this->title = $settings->firstWhere('name', 'title')->payload;
        $this->image = $settings->firstWhere('name', 'image')->payload;
        $this->content = $settings->firstWhere('name', 'content')->payload;
        $this->oneTimeOptions = $settings->firstWhere('name', 'onetime')->payload;
        $this->monthlyOptions = $settings->firstWhere('name', 'monthly')->payload;

        $this->checkEmail($this->email);
    }

    public function updatedEmail($value)
    {
        $this->checkEmail($value);
    }

    public function render()
    {
        return view('livewire.app.donations.create')
            ->with([
                'amountLabel' => $this->amountLabel,
            ]);
    }

    // Properties

    public function getAmountLabelProperty()
    {
        if ($this->amount != '') {
            return '$' . $this->amount . ' ';
        }
    }

    // Methods

    public function checkEmail($email)
    {
        $user = User::firstWhere('email', $email);

        if (! $user && auth()->check()) {
            $this->emit('notify', ['message' => 'Looks like the email entered does not match the email that is logged in.', 'type' => 'error']);
        } elseif (! $user && $email !== '') {
            $this->newUser = true;
        } elseif ($user && ! auth()->check()) {
            $this->hasLogin = true;
            $this->showLogin($email);
        }
    }

    public function chooseAmount($amount)
    {
        $this->amount = $amount;
        if ($this->type === 'one-time' && $this->otherAmount) {
            $this->otherAmount = false;
        }
    }

    public function chooseOther()
    {
        $this->otherAmount = true;
        $this->amount = '';
    }

    public function showLogin($email = null)
    {
        $this->emit('showLogin', ['email' => $email ?? $this->email]);
    }

    public function saveAddress()
    {
        $data = $this->validate([
            'address.line1' => ['required'],
            'address.line2' => ['nullable'],
            'address.city' => ['required'],
            'address.state' => ['required'],
            'address.zip' => ['required'],
            'address.country' => ['required'],
        ], [
            'address.line1.required' => 'Street address is required',
            'address.city.required' => 'City is required',
            'address.state.required' => 'State is required',
            'address.zip.required' => 'ZIP or Postal Code is required',
            'address.country.required' => 'Country is required',
        ]);

        auth()->user()->address = $data['address'];
        auth()->user()->save();
    }

    public function startPayment()
    {
        $this->validate();

        if (auth()->guest() && $this->newUser) {
            $password = Str::random(15);
            $user = User::create(['name' => $this->name, 'email' => $this->email, 'password' => Hash::make($password)]);
            session(['was_created' => true]);

            Auth::attempt(['email' => $this->email, 'password' => $password]);
        } elseif (auth()->guest()) {
            return $this->emit('notify', ['message' => 'Please login before continuing.', 'type' => 'error']);
        } elseif ($this->type === 'monthly' && auth()->user()->hasRecurringDonation()) {
            return $this->emit('notify', ['message' => 'You already have an active recurring donation.', 'type' => 'error']);
        } else {
            $user = auth()->user();
        }

        if ($donation = auth()->user()->incompleteDonations()->where('amount', $this->amount * 100)->where('type', $this->type)->first()) {
            $paymentIntent = PaymentIntent::retrieve($donation->transaction_id);
        } elseif ($this->type === 'one-time') {
            $paymentIntent = PaymentIntent::create([
                'amount' => $this->amount * 100,
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            $donation = Donation::create([
                'user_id' => $user->id,
                'transaction_id' => $paymentIntent->id,
                'amount' => $this->amount * 100,
                'type' => $this->type
            ]);
        } elseif ($this->type === 'monthly') {
            $subscription = Subscription::create([
                'customer' => $user->createOrGetStripeCustomer()->id,
                'items' => [[
                    'price' => array_search($this->amount, $this->monthlyOptions),
                ]],
                'payment_behavior' => 'default_incomplete',
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            $paymentIntent = $subscription->latest_invoice->payment_intent;
            $donation = Donation::create([
                'user_id' => $user->id,
                'transaction_id' => $paymentIntent->id,
                'subscription_id' => $subscription->id,
                'amount' => $this->amount * 100,
                'type' => $this->type
            ]);
        }

        $this->clientSecret = $paymentIntent->client_secret;

        $this->step = 2;
    }
}
