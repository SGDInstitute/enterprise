<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="h-12 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth.session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <x-bit.input.group for="name" :label="__('Name')" :error="$errors->first('name')">
                <x-bit.input.text
                    id="name"
                    class="mt-1 block w-full"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                />
            </x-bit.input.group>

            <!-- Email Address -->
            <x-bit.input.group for="email" :label="__('Email')" class="mt-4" :error="$errors->first('email')">
                <x-bit.input.text
                    id="email"
                    class="mt-1 block w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                />
            </x-bit.input.group>

            <!-- Password -->
            <x-bit.input.group
                for="password"
                :label="__('Password')"
                :error="$errors->first('password')"
                class="mt-4"
            >
                <x-bit.input.text
                    id="password"
                    class="mt-1 block w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                />
            </x-bit.input.group>

            <!-- Confirm Password -->
            <x-bit.input.group
                for="password_confirmation"
                :label="__('Confirm Password')"
                :error="$errors->first('password_confirmation')"
                class="mt-4"
            >
                <x-bit.input.text
                    id="password_confirmation"
                    class="mt-1 block w-full"
                    type="password"
                    name="password_confirmation"
                    required
                />
            </x-bit.input.group>

            <x-honey />

            <div class="mt-4 flex items-center justify-end">
                <a
                    class="text-sm text-gray-600 underline hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200"
                    href="{{ route('login') }}"
                >
                    {{ __('Already registered?') }}
                </a>

                <x-bit.button.flat.primary type="submit" class="ml-4">
                    {{ __('Register') }}
                </x-bit.button.flat.primary>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
