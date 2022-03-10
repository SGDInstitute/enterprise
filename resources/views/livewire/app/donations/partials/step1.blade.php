<div class="space-y-6">
    <div class="space-y-2">
        <h2 class="text-gray-900 dark:text-gray-200">Personal Information</h2>
        <x-form.group label="Name" model="name" type="text" />
        <x-form.group label="Email" model="email" type="email" autocomplete="email" />

        @if($newUser)
        <x-bit.alert>Looks like you're a new user, we will create an account for you and email you instructions on how to set your password</x-bit.alert>
        @elseif($hasLogin)
        <x-bit.alert>
            Looks like you have an account, but haven't logged in yet.
            <x-slot name="button">
                <button wire:click="showLogin" type="button" class="font-medium text-blue-700 dark:text-blue-200 whitespace-nowrap hover:text-blue-600 dark:hover:text-blue-100">Login Now <span aria-hidden="true">&rarr;</span></a>
            </x-slot>
        </x-bit.alert>
        @endif
    </div>

    <div class="space-y-2">
        <h2 class="text-gray-900 dark:text-gray-200">Choose Amount to Donate</h2>

        <div class="space-y-6">
            <div class="flex">
                <button type="button" wire:click="$set('type', 'monthly')" class="inline-flex items-center justify-center w-full px-4 py-2 uppercase border-2 border-green-500 font-bold dark:border-green-400 {{ $type === 'monthly' ? 'bg-green-600 dark:bg-green-500 text-white' : 'text-green-500 dark:text-green-400 hover:bg-green-500 hover:text-white dark:hover:bg-green-400' }}">Monthly</button>
                <button type="button" wire:click="$set('type', 'one-time')" class="inline-flex items-center justify-center w-full px-4 py-2 -ml-px uppercase border-2 border-green-500 font-bold dark:border-green-400 {{ $type === 'one-time' ? 'bg-green-600 dark:bg-green-500 text-white' : 'text-green-500 dark:text-green-400 hover:bg-green-500 hover:text-white dark:hover:bg-green-400' }}">Give Once</button>
            </div>

            @if($type === 'monthly')
            <div class="grid grid-cols-3 gap-2">
                @foreach ($monthlyOptions as $option)
                <button class="btn btn-base btn-block {{ $amount == $option ? 'btn-green' : 'btn-gray' }}" id="monthly-button-{{ $option }}" wire:click="chooseAmount({{ $option }})">${{ $option }}</button>
                @endforeach
            </div>
            @else
            <div class="grid grid-cols-3 gap-2">
                @foreach ($oneTimeOptions as $option)
                    @if($option === 'other')
                        @if($otherAmount)
                        <x-bit.input.group for="other-amount" class="col-span-2" label="Other Amount" sr-only>
                            <x-bit.input.text id="other-amount" class="block w-full" type="number" name="other-amount" wire:model="amount" placeholder="Other Amount" required leading-add-on="$" />
                        </x-bit.input.group>
                        @else
                        <button class="col-span-2 btn-gray btn btn-base btn-block" wire:click="chooseOther">Other Amount</button>
                        @endif
                    @else
                    <button class="btn btn-base btn-block {{ $amount == $option ? 'btn-green' : 'btn-gray' }}" id="one-time-button-{{ $option }}" wire:click="chooseAmount({{ $option }})">${{ $option }}</button>
                    @endif
                @endforeach
            </div>
            @endif
        </div>
    </div>

    @error('amount')
    <div class="mt-1 text-red-500">{{ $message }}</div>
    @enderror

    <x-bit.button.flat.accent-filled block wire:click="startPayment" size="large">
        Continue to Payment
    </x-bit.button.flat.accent-filled>
</div>
