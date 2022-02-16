<?php

namespace App\Http\Livewire\App\Donations;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Stripe\PaymentIntent;
use Stripe\Stripe;

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

    public $oneTimeOptions = [10,20,50,100];
    public $monthlyOptions = [5,10,20,25,50,100];

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
        'amount' => ['except' => ''],
        'name' => ['except' => ''],
        'email' => ['except' => ''],
    ];

    public function updatedEmail($value)
    {
        $this->checkEmail($value);
    }

    public function mount()
    {
        if(auth()->check()) {
            $this->name = auth()->user()->name;
            $this->email = auth()->user()->email;
        }

        $this->checkEmail($this->email);
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
        if($this->amount != '') {
            return '$' . $this->amount . ' ';
        }
    }

    // Methods

    public function checkEmail($email)
    {
        $user = User::firstWhere('email', $email);

        if(!$user && auth()->check()) {
            $this->emit('notify', ['message' => 'Looks like the email entered does not match the email that is logged in.', 'type' => 'error']);
        } elseif(!$user && $email !== '') {
            $this->newUser = true;
        } elseif($user && !auth()->check()) {
            $this->hasLogin = true;
            $this->showLogin($email);
        }
    }

    public function chooseAmount($amount)
    {
        $this->amount = $amount;
        if($this->type === 'one-time' && $this->otherAmount) {
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

    public function startPayment()
    {
        $this->validate();

        if(auth()->guest() && $this->newUser) {
            $password = Str::random(15);
            $user = User::create(['name' => $this->name, 'email' => $this->email, 'password' => Hash::make($password)]);
            Auth::attempt(['email' => $this->email, 'password' => $password]);
        } elseif(auth()->guest()) {
            return $this->emit('notify', ['message' => 'Please login before continuing.', 'type' => 'error']);
        }

        if($donation = auth()->user()->pendingDonations()->where('amount', $this->amount)->where('type', $this->type)->first()) {
            $paymentIntent = PaymentIntent::retrieve($donation->transaction_id);
        } else {
            $paymentIntent = PaymentIntent::create([
                'amount' => $this->amount * 100,
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            $donation = Donation::create([
                'user_id' => auth()->id(),
                'transaction_id' => $paymentIntent->id,
                'amount' => $this->amount * 100,
                'type' => $this->type
            ]);
        }

        $this->clientSecret = $paymentIntent->client_secret;

        $this->step = 2;
    }
}
