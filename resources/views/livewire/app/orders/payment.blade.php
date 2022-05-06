<div>
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold leading-7 text-gray-900 dark:text-gray-100 sm:text-2xl sm:truncate">Payment</h2>
        <div class="space-x-1">
            <x-bit.button.flat.primary wire:click="downloadInvoice" size="xs" class="space-x-2">
                <x-heroicon-o-download class="w-4 h-4" /> <span>Download Invoice</span>
            </x-bit.button.flat.primary>
            <x-bit.button.flat.primary wire:click="downloadW9" size="xs" class="space-x-2">
                <x-heroicon-o-download class="w-4 h-4" /> <span>Download W9</span>
            </x-bit.button.flat.primary>
        </div>
    </div>

    <form id="payment-form" class="mt-6 space-y-6">
        @if (! $order->isPaid())
        <div class="p-4 space-y-4 bg-white shadow-md dark:bg-gray-800 dark:border-gray-700 dark:border">
            <h2 class="text-gray-900 dark:text-gray-200">Billing Address</h2>
            <div class="grid grid-cols-2 gap-4">
                <x-form.group type="text" model="name" label="Name" />
                <x-form.group type="email" model="email" label="Email" />
            </div>
            <x-form.address wire:model="address" />
        </div>

        <div class="p-4 space-y-4 bg-white shadow-md dark:bg-gray-800 dark:border-gray-700 dark:border">
            <h2 class="text-gray-900 dark:text-gray-200">Payment Information</h2>

            <div id="payment-element" wire:ignore></div>

            <div id="payment-message" class="hidden text-red-500 dark:text-red-400"></div>

            <div class="flex space-x-4">
                <x-bit.button.flat.accent-filled wire:ignore type="submit" block id="submit" size="large">
                    <svg class="hidden w-6 h-6 mr-2 text-gray-900 animate-spin" id="spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Pay {{ $order->formattedAmount }} for {{ $order->tickets->count() }} Ticket{{ $order->tickets->count() > 1 ? 's' : ''}}</span>
                </x-bit.button.flat.accent-filled>

                <x-bit.button.flat.secondary href="{{ route('app.orders.show', [$order, 'tickets']) }}" block class="w-1/4">
                    Skip for Now
                </x-bit.button.flat.secondary>
            </div>
        </div>

        <script>
            const stripe = Stripe("{{ config('services.stripe.key') }}");

            let elements;

            initialize();
            checkStatus();

            document
                .querySelector("#payment-form")
                .addEventListener("submit", handleSubmit);

            // Fetches a payment intent and captures the client secret
            async function initialize() {
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    var rules = {
                        '.Label': {
                            color: 'rgb(156, 163, 175)',
                            fontWeight: 500,
                            fontSize: '0.875rem',
                            lineHeight: '1.25rem',
                        },
                        '.Input': {
                            backgroundColor: 'transparent',
                            color: 'rgb(229, 231, 235)',
                            borderRadius: '0.375rem',
                            fontSize: '1rem',
                            lineHeight: '1.5rem',
                            border: '1px solid rgb(55, 65, 81)',
                            boxShadow: 'rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.05) 0px 1px 2px 0px',
                        }
                    }
                } else {
                    var rules = {
                        '.Label': {
                            color: 'rgb(55, 65, 81)',
                            fontWeight: 500,
                            fontSize: '0.875rem',
                            lineHeight: '1.25rem',
                        },
                        '.Input': {
                            backgroundColor: 'transparent',
                            borderRadius: '0.375rem',
                            fontSize: '1rem',
                            lineHeight: '1.5rem',
                            border: '1px solid rgb(209, 213, 219)',
                            boxShadow: 'rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.05) 0px 1px 2px 0px',
                        }
                    }
                }

                elements = stripe.elements({
                    clientSecret: @js($clientSecret),
                    fonts: [{
                        cssSrc: 'https://fonts.googleapis.com/css?family=Lato'
                    }],
                    appearance: {
                        theme: 'none',
                        variables: {
                            fontFamily: 'Lato, system-ui, sans-serif'
                        },
                        rules,
                    }
                });

                var paymentElement = elements.create('payment', {
                    fields: {
                        billingDetails: {
                            address: {
                                postalCode: 'never',
                                country: 'never',
                            }
                        }
                    }
                });

                paymentElement.mount("#payment-element");
            }

            async function handleSubmit(e) {
                e.preventDefault();
                setLoading(true);

                @this.saveBillingInfo()

                if (@this.address.zip !== '') {
                    const {
                        error
                    } = await stripe.confirmPayment({
                        elements,
                        confirmParams: {
                            // Make sure to change this to your payment completion page
                            return_url: '{{ url("/orders/process") }}',
                            payment_method_data: {
                                billing_details: {
                                    name: '{{ $name }}',
                                    email: '{{ $email }}',
                                    address: {
                                        country: 'us',
                                        postal_code: '{{ $address["zip"] }}'
                                    }
                                }
                            },
                        },
                    });

                    if (error.type === "card_error" || error.type === "validation_error") {
                        showMessage(error.message);
                    } else {
                        showMessage("An unexpected error occured.");
                    }
                }

                setLoading(false);
            }

            // Fetches the payment intent status after payment submission
            async function checkStatus() {
                const clientSecret = new URLSearchParams(window.location.search).get(
                    "payment_intent_client_secret"
                );

                if (!clientSecret) {
                    return;
                }

                const {
                    paymentIntent
                } = await stripe.retrievePaymentIntent(clientSecret);

                switch (paymentIntent.status) {
                    case "succeeded":
                        showMessage("Payment succeeded!");
                        break;
                    case "processing":
                        showMessage("Your payment is processing.");
                        break;
                    case "requires_payment_method":
                        showMessage("Your payment was not successful, please try again.");
                        break;
                    default:
                        showMessage("Something went wrong.");
                        break;
                }
            }

            // ------- UI helpers -------

            function showMessage(messageText) {
                const messageContainer = document.querySelector("#payment-message");

                messageContainer.classList.remove("hidden");
                messageContainer.textContent = messageText;

                setTimeout(function() {
                    messageContainer.classList.add("hidden");
                    messageText.textContent = "";
                }, 4000);
            }

            // Show a spinner on payment submission
            function setLoading(isLoading) {
                if (isLoading) {
                    document.querySelector("#submit").disabled = true;
                    document.querySelector("#submit").classList.add("disabled");
                    document.querySelector("#spinner").classList.remove("hidden");
                } else {
                    document.querySelector("#submit").disabled = false;
                    document.querySelector("#submit").classList.remove("disabled");
                    document.querySelector("#spinner").classList.add("hidden");
                }
            }
        </script>
        @else
        <div class="p-4 space-y-4 bg-white shadow-md dark:bg-gray-800 dark:border-gray-700 dark:border">
            <h2 class="text-gray-900 dark:text-gray-200">Payment Details</h2>

            <dl class="grid grid-cols-2 mt-16 text-sm text-gray-600 gap-x-4">
                <div>
                    <dt class="font-medium text-gray-900">Billing Address</dt>
                    <dd class="mt-2">
                        <address class="not-italic">
                            <span class="block">{{ $order->invoice['name'] }}</span>
                            <span class="block">{{ $order->invoice['email'] }}</span>
                            <span class="block">{{ $order->formattedAddress }}</span>
                        </address>
                    </dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900">Payment Information</dt>
                    <dd class="mt-2 space-y-2 sm:flex sm:space-y-0 sm:space-x-4">
                        <div class="flex-none">
                            @if ($transaction['type'] === 'card')
                            <x-dynamic-component :component="'card-' . $transaction['brand']" class="w-auto h-6" />
                            <p class="sr-only">{{ ucfirst($transaction['brand']) }}</p>
                            @elseif ($transaction['type'] === 'check')
                            <x-heroicon-s-ticket class="w-auto h-6" />
                            <p class="sr-only">Check</p>
                            @endif
                        </div>
                        <div class="flex-auto">
                            @if ($transaction['type'] === 'card')
                            <p class="text-gray-900">Ending with {{ $transaction['last4'] }}</p>
                            <p>Expires {{ $transaction['exp'] }}</p>
                            @elseif ($transaction['type'] === 'check')
                            <p class="text-gray-900">Number {{ $transaction['check_number'] }}</p>
                            @endif
                            <p>Amount {{ $order->formattedAmount }}</p>
                        </div>
                    </dd>
                </div>
            </dl>
        </div>

        <x-bit.button.flat.accent-filled wire:click="downloadInvoice" block id="submit" size="large" class="space-x-2">
            <x-heroicon-o-download class="w-6 h-6" /> <span>Download Receipt</span>
            </x-bit.button.flat.primary>
            @endif
    </form>
</div>
