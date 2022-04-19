<div class="space-y-12">
    <h2 class="text-xl font-bold leading-7 text-gray-900 dark:text-gray-100 sm:text-2xl sm:truncate">Payment</h2>

    <form id="payment-form" class="space-y-6">
        <div class="space-y-2">
            <h2 class="text-gray-900 dark:text-gray-200">Billing Address</h2>
            <x-form.address wire:model="address" />
        </div>

        <div class="space-y-2">
            <h2 class="text-gray-900 dark:text-gray-200">Payment Information</h2>
            <div id="payment-element" wire:ignore></div>
        </div>

        <x-bit.button.flat.accent-filled wire:ignore type="submit" block id="submit" size="large">
            <svg class="hidden w-6 h-6 mr-2 text-gray-900 animate-spin" id="spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Pay {{ $order->formattedAmount }}</span>
        </x-bit.button.flat.accent-filled>

        <div id="payment-message" class="hidden text-red-500 dark:text-red-400"></div>

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
                    fonts: [
                        {cssSrc: 'https://fonts.googleapis.com/css?family=Lato'}
                    ],
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

                @this.saveAddress();

                const {
                    error
                } = await stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        // Make sure to change this to your payment completion page
                        return_url: '{{ url("/donations/process") }}',
                        payment_method_data: {
                            billing_details: {
                                name: '{{ auth()->user()->name }}',
                                email: '{{ auth()->user()->email }}',
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
    </form>
</div>
