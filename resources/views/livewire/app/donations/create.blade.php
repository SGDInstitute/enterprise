<div>
    <section class="mb-4">
        <div class="bg-center bg-no-repeat bg-cover h-60 md:h-96" style="background-image: url(https://sgdinstitute.org/assets/headers/header-test2.jpg)">

        </div>
        <div class="w-4/5 px-8 py-4 -mt-6 bg-yellow-300 md:w-2/3">
            <h1 class="text-4xl text-gray-700 font-news-cycle">Support our work</h1>
        </div>
    </section>

    <div class="grid grid-cols-1 gap-20 px-12 pt-12 mx-auto md:px-0 md:max-w-4xl md:grid-cols-2">
        <div class="space-y-8">
            <div class="flex rounded-md">
                <button type="button" wire:click="$set('form.type', 'monthly')" class="inline-flex items-center justify-center w-full px-4 py-2 uppercase border-2 border-green-500 font-bold dark:border-green-400 {{ $form['type'] === 'monthly' ? 'bg-green-600 dark:bg-green-500 text-white' : 'text-green-500 dark:text-green-400 hover:bg-green-500 hover:text-white dark:hover:bg-green-400' }}">Monthly</button>
                <button type="button" wire:click="$set('form.type', 'one-time')" class="inline-flex items-center justify-center w-full px-4 py-2 -ml-px uppercase border-2 border-green-500 font-bold dark:border-green-400 {{ $form['type'] === 'one-time' ? 'bg-green-600 dark:bg-green-500 text-white' : 'text-green-500 dark:text-green-400 hover:bg-green-500 hover:text-white dark:hover:bg-green-400' }}">Give Once</button>
            </div>

            @if($step === 1)
            <div class="space-y-6">
                @includeWhen($form['type'] === 'monthly', 'livewire.app.donations.partials.monthly')
                @includeWhen($form['type'] === 'one-time', 'livewire.app.donations.partials.one-time')

                @error('form.amount')
                <div class="mt-1 text-red-500">{{ $message }}</div>
                @enderror

                <x-bit.button.flat.accent-filled block wire:click="startPayment" size="large">
                    Donate {{ $amountLabel }}{{ $form['type'] === 'monthly' ? 'Monthly' : 'Now' }}
                </x-bit.button.flat.accent-filled>
            </div>
            @elseif($step === 2)
            <form id="payment-form" class="space-y-4">
                <div class="space-y-2">
                    <x-form.group label="Name" model="form.name" type="text" />
                    <x-form.group label="Email" model="form.email" type="email" autocomplete="email" />

                    <div id="payment-element" wire:ignore></div>
                </div>

                <x-bit.button.flat.accent-filled block id="submit" size="large">
                    Donate {{ $amountLabel }}{{ $form['type'] === 'monthly' ? 'Monthly' : 'Now' }}
                </x-bit.button.flat.accent-filled>

                <div id="payment-message" class="hidden"></div>

            </form>

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

                    console.log(rules);

                    elements = stripe.elements({
                        clientSecret: @js($clientSecret),
                        appearance: {
                            theme: 'none',
                            rules,
                        }
                    });

                    const paymentElement = elements.create("payment");
                    paymentElement.mount("#payment-element");
                }

                async function handleSubmit(e) {
                    e.preventDefault();
                    setLoading(true);

                    const {
                        error
                    } = await stripe.confirmPayment({
                        elements,
                        confirmParams: {
                            // Make sure to change this to your payment completion page
                            return_url: "http://localhost:4242/public/checkout.html",
                        },
                    });

                    // This point will only be reached if there is an immediate error when
                    // confirming the payment. Otherwise, your customer will be redirected to
                    // your `return_url`. For some payment methods like iDEAL, your customer will
                    // be redirected to an intermediate site first to authorize the payment, then
                    // redirected to the `return_url`.
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
                        // Disable the button and show a spinner
                        document.querySelector("#submit").disabled = true;
                        document.querySelector("#spinner").classList.remove("hidden");
                        document.querySelector("#button-text").classList.add("hidden");
                    } else {
                        document.querySelector("#submit").disabled = false;
                        document.querySelector("#spinner").classList.add("hidden");
                        document.querySelector("#button-text").classList.remove("hidden");
                    }
                }
            </script>
            @endif
        </div>
        <div class="prose dark:prose-light">
            <p>The Midwest Institute for Sexuality and Gender Diversity re-envisions an educational climate that centers the needs and experiences of systemically disadvantaged students and affirms and encourages sexuality and gender diversity.</p>

            <p>Our life-saving work is made possible through the generous financial support of grassroots donors. We invite you to join us with a monthly or one-time gift. Your donation will support our efforts to build community and build strong movements.</p>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
@endpush
