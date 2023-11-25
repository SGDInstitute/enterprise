<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    @php
        $key = config('services.stripe.key');
        $amount = $getCalculatedAmount();
        if (! empty($amount) && $amount > 0) {
            $clientSecret = $getClientSecret();
        }
    @endphp

    @isset($clientSecret)
    <div
        x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }"
        x-init="
            const stripe = Stripe(@js($key));
            const clientSecret = @js($clientSecret);

            elements = stripe.elements({ clientSecret });
            const paymentElement = elements.create('payment');

            paymentElement.mount($refs.payment);
        "
    >
        <div x-ref="payment" wire:ignore></div>
    </div>
    @endisset
</x-dynamic-component>
