<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <bit.input.group for="email" :label="__('Email')">
                <x-bit.input.text id="email" class="block w-full mt-1" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </bit.input.group>

            <!-- Password -->
            <x-bit.input.group for="password" :label="__('Password')" class="mt-4">
                <x-bit.input.text id="password" class="block w-full mt-1" type="password" name="password" required />
            </x-bit.input.group>

            <!-- Confirm Password -->
            <x-bit.input.group for="password_confirmation" :label="__('Confirm Password')" class="mt-4">
                <x-bit.input.text id="password_confirmation" class="block w-full mt-1"
                                    type="password"
                                    name="password_confirmation" required />
            </x-bit.input.group>

            <div class="flex items-center justify-end mt-4">
                <x-bit.button.primary>
                    {{ __('Reset Password') }}
                </x-bit.button.primary>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
