<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input.label for="name" :value="__('Name')" />

                <x-input.text id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input.label for="email" :value="__('Email')" />

                <x-input.text id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input.label for="password" :value="__('Password')" />

                <x-input.text id="password" class="block w-full mt-1"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input.label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input.text id="password_confirmation" class="block w-full mt-1"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm text-gray-600 underline dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button.primary class="ml-4">
                    {{ __('Register') }}
                </x-button.primary>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
