<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    @php
        $key = config('services.stripe.key');
    @endphp

    <div x-data="stripe">
        <div x-ref="payment" wire:ignore></div>
        <x-filament::button @click="process" class="mt-2 w-full text-center block">
            Donate <span x-html="formattedAmount"></span>
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
            formattedAmount() {
                return '$' + this.amount / 100
            },
            async process() {
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
                                    postal_code: @js(auth()->user()->address['zip'])
                                }
                            }
                        },
                    },
                })

                if (error.type === "card_error" || error.type === "validation_error") {
                    this.message = error.message
                } else {
                    this.message = "An unexpected error occurred."
                }
            },
            init() {
                this.$watch('clientSecret', () => {
                    stripe = Stripe(@js($key))

                    elements = stripe.elements({ clientSecret: this.clientSecret })
                    const paymentElement = elements.create('payment', {
                        fields: {
                            billingDetails: {
                                address: {
                                    postalCode: 'never',
                                    country: 'never',
                                }
                            }
                        }
                    })

                    paymentElement.mount(this.$refs.payment)
                })
            }
        }
    })
</script>
@endscript
