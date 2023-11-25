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
        $options = $getOptions();
    @endphp

    @isset($clientSecret)
    <div
        x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }"
        x-init="
            const stripe = Stripe(@js($key));
            const clientSecret = @js($clientSecret);

            elements = stripe.elements({ clientSecret });

            @if ($options)
            const paymentElement = elements.create('payment', @js($options));
            @else
            const paymentElement = elements.create('payment');
            @endif
            paymentElement.mount($refs.payment);
        "
    >
        <div x-ref="payment" wire:ignore></div>
    </div>
    @endisset
</x-dynamic-component>
