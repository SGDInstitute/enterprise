<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="h-12 text-gray-500 fill-current" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-200">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <!-- Validation Errors -->
        <x-auth.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <x-bit.input.group for="password" :value="__('Password')">
                <x-bit.input.text id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="current-password" />
            </x-bit.input.group>

            <div class="flex justify-end mt-4">
                <x-bit.button.flat.primary>
                    {{ __('Confirm') }}
                </x-bit.button.flat.primary>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
