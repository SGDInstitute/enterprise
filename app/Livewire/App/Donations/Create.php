<?php

namespace App\Livewire\App\Donations;

use App\Forms\Components\Payment;
use App\Models\Donation;
use App\Models\Setting;
use App\Models\User;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Livewire\Notifications;
use Filament\Notifications\Notification;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Livewire\Component;
use Stripe\PaymentIntent;
use Stripe\Subscription;

class Create extends Component implements HasForms
{
    use InteractsWithForms;

    public $title;

    public $image;

    public $content;

    public ?array $data = [];

    public $amount;
    public Donation $donation;
    public $clientSecret;

    public function mount()
    {
        $settings = Setting::where('group', 'donations.page')->get();
        $this->title = $settings->firstWhere('name', 'title')->payload;
        $this->image = $settings->firstWhere('name', 'image')->payload;
        $this->content = $settings->firstWhere('name', 'content')->payload;

        $this->form->fill([
            'type' => 'monthly',
            'address' => auth()->user()->address ?? [],
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Choose Type & Amount')
                        ->schema([
                            Radio::make('type')
                                ->disabled($this->formIsDisabled)
                                ->live()
                                ->options([
                                    'monthly' => 'Monthly',
                                    'one-time' => 'One Time',
                                ])
                                ->required(),
                            Radio::make('amount')
                                ->disabled($this->formIsDisabled)
                                ->live()
                                ->options(function (Get $get) {
                                    return match($get('type')) {
                                        'monthly' => [
                                            '500' => '$5 / month',
                                            '1000' => '$10 / month',
                                            '2000' => '$20 / month',
                                            '2500' => '$25 / month',
                                            '5000' => '$50 / month',
                                            '10000' => '$100 / month',
                                        ],
                                        'one-time' => [
                                            '1000' => '$10',
                                            '2000' => '$20',
                                            '5000' => '$50',
                                            '10000' => '$100',
                                            'other' => 'Other Amount',
                                        ],
                                    };
                                })
                                ->required(),
                            TextInput::make('other_amount')
                                ->disabled($this->formIsDisabled)
                                ->hidden(fn (Get $get) => $get('amount') !== 'other')
                                ->live()
                                ->money(),
                        ]),
                    Step::make('Billing Address')
                        ->afterValidation(function () {
                            $data = $this->form->getState();
                            $this->saveAddress($data['address']);

                            $this->setupPayment($data);
                        })
                        ->schema([
                            Select::make('search')
                                ->afterStateUpdated(function (Set $set, ?string $state) {
                                    $parts = explode(', ', $state);

                                    $set('address.line1', $parts[0]);
                                    $set('address.city', $parts[1]);
                                    // $parts[2] will be state and zip i.e. Illinois 60516
                                    $set('address.state', explode(' ', $parts[2])[0]);
                                    $set('address.zip', explode(' ', $parts[2])[1]);
                                    $set('address.country', $parts[3]);
                                })
                                ->disabled($this->formIsDisabled)
                                ->getSearchResultsUsing(function (string $search) {
                                    $results = Http::retry(3, 100)
                                        ->withQueryParameters([
                                            "country" => "us",
                                            "limit" => "5",
                                            "types" => "address,place",
                                            "language" => "en-US",
                                            "access_token" => config("services.mapbox.key")
                                        ])
                                        ->get(
                                            "https://api.mapbox.com/geocoding/v5/mapbox.places/" . $search . ".json"
                                        )
                                        ->onError(
                                        fn() => Notifications::make()
                                            ->title("Address API Issue")
                                            ->send()
                                        )
                                        ->json()['features'];
                                    return collect($results)->pluck('place_name', 'place_name');
                                })
                                ->label('Address Search')
                                ->live()
                                ->placeholder('Search for your billing address')
                                ->prefixIcon('heroicon-o-map-pin')
                                ->searchable(),
                            Grid::make(2)
                                ->disabled($this->formIsDisabled)
                                ->schema([
                                    TextInput::make('address.line1')
                                        ->label('Address')
                                        ->required(),
                                    TextInput::make('address.line2')
                                        ->label('Address 2'),
                                ]),
                            Grid::make(3)
                                ->disabled($this->formIsDisabled)
                                ->schema([
                                    TextInput::make('address.city')
                                        ->required(),
                                    TextInput::make('address.state')
                                        ->required(),
                                    TextInput::make('address.zip')
                                        ->required(),
                                ]),
                        ]),
                    Step::make('Payment Details')
                        ->schema([
                            Payment::make('payment')
                                ->amount($this->amount)
                                ->clientSecret($this->clientSecret)
                                ->returnUrl(url('/donations/process'))
                                ->hidden($this->formIsDisabled),
                        ]),
                ])->disabled($this->formIsDisabled)
            ])
            ->statePath('data');
    }

    public function getFormIsDisabledProperty(): bool
    {
        return auth()->guest() || auth()->user()->hasVerifiedEmail() === false;
    }

    public function render()
    {
        return view('livewire.app.donations.create');
    }

    private function setupPayment($data)
    {
        $this->amount = $data['amount'] === 'other' ? $data['other_amount'] * 100 : $data['amount'];

        if ($data['type'] === 'one-time') {
            $paymentIntent = PaymentIntent::create([
                'amount' => $this->amount,
                'currency' => 'usd',
            ]);

            $this->donation = Donation::create([
                'user_id' => auth()->id(),
                'transaction_id' => $paymentIntent->id,
                'amount' => $this->amount,
                'type' => $data['type'],
            ]);
        } elseif ($data['type'] === 'monthly') {
            $subscription = Subscription::create([
                'customer' => auth()->user()->createOrGetStripeCustomer()->id,
                'items' => [[
                    'price' => array_search($this->amount, $this->monthlyOptions),
                ]],
                'payment_behavior' => 'default_incomplete',
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            $paymentIntent = $subscription->latest_invoice->payment_intent;
            $this->donation = Donation::create([
                'user_id' => auth()->id(),
                'transaction_id' => $this->paymentIntent->id,
                'subscription_id' => $subscription->id,
                'amount' => $this->amount,
                'type' => $data['type'],
            ]);

        }

        $this->clientSecret = $paymentIntent->client_secret;
    }

    private function saveAddress($address)
    {
        // save address
        auth()->user()->update(['address' => $address]);
    }
}
