<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @php
        $key = config('services.stripe.key');
    @endphp

    <div x-data="stripe">
        <div x-ref="payment" wire:ignore></div>
        <div class="text-red-500" x-show="message" x-html="message"></div>
        <x-filament::button @click="process" class="mt-2 w-full text-center" x-bind:disabled="processing">
            <div class="flex items-center">
                <svg
                    x-show="processing"
                    class="-ml-1 mr-3 h-5 w-5 animate-spin text-white"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                    ></path>
                </svg>
                <span>
                    Donate
                    <span x-html="formattedAmount"></span>
                </span>
            </div>
        </x-filament::button>
    </div>
</x-dynamic-component>

@script
    <script>
        Alpine.data('stripe', () => {
            return {
                amount: $wire.$entangle('amount'),
                clientSecret: $wire.$entangle('clientSecret'),
                message: false,
                stripe: false,
                elements: false,
                processing: false,
                formattedAmount() {
                    return '$' + this.amount / 100;
                },
                async process() {
                    if (this.processing) {
                        return;
                    }

                    this.processing = true;
                    if (this.message !== false) {
                        this.message = false;
                    }
                    const { error } = await stripe.confirmPayment({
                        elements,
                        confirmParams: {
                            // Make sure to change this to your payment completion page
                            return_url: @js($getReturnUrl()),
                            receipt_email: @js($getReceiptEmail()),
                            payment_method_data: {
                                billing_details: {
                                    name: @js(auth()->user()->name),
                                    email: @js($getReceiptEmail()),
                                    address: {
                                        country: 'us',
                                        postal_code: @js(auth()->user()->address['zip'] ?? ''),
                                    },
                                },
                            },
                        },
                    });

                    this.processing = false;
                    if (error.type === 'card_error' || error.type === 'validation_error') {
                        this.message = error.message;
                    } else {
                        this.message = 'An unexpected error occurred.';
                    }
                },
                init() {
                    this.$watch('clientSecret', () => {
                        stripe = Stripe(@js($key));

                        elements = stripe.elements({ clientSecret: this.clientSecret });
                        const paymentElement = elements.create('payment', {
                            fields: {
                                billingDetails: {
                                    address: {
                                        postalCode: 'never',
                                        country: 'never',
                                    },
                                },
                            },
                        });

                        paymentElement.mount(this.$refs.payment);
                    });
                },
            };
        });
    </script>
@endscript
