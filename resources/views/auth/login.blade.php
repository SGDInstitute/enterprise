<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth.session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <x-bit.input.group for="email" :label="__('Email')">
                <x-bit.input.text id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
            </x-bit.input.group>

            <!-- Password -->
            <x-bit.input.group for="password" :label="__('Password')" class="mt-4">
                <x-bit.input.text id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="current-password" />
            </x-bit.input.group>

            <!-- Remember Me -->
            <div class="block mt-4">
                <x-bit.input.checkbox id="remember_me" name="remember">{{ __('Remember me') }}</x-input.checkbox>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 underline dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-bit.button.flat.primary type="submit" class="ml-3">
                    {{ __('Login') }}
                </x-bit.button.flat.primary>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
