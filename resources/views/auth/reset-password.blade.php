<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="h-12 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}" />

            <!-- Email Address -->
            <bit.input.group for="email" :label="__('Email')">
                <x-bit.input.text
                    id="email"
                    class="mt-1 block w-full"
                    type="email"
                    name="email"
                    :value="old('email', $request->email)"
                    required
                    autofocus
                />
            </bit.input.group>

            <!-- Password -->
            <x-bit.input.group for="password" :label="__('Password')" class="mt-4">
                <x-bit.input.text id="password" class="mt-1 block w-full" type="password" name="password" required />
            </x-bit.input.group>

            <!-- Confirm Password -->
            <x-bit.input.group for="password_confirmation" :label="__('Confirm Password')" class="mt-4">
                <x-bit.input.text
                    id="password_confirmation"
                    class="mt-1 block w-full"
                    type="password"
                    name="password_confirmation"
                    required
                />
            </x-bit.input.group>

            <div class="mt-4 flex items-center justify-end">
                <x-bit.button.flat.primary type="submit">
                    {{ __('Reset Password') }}
                </x-bit.button.flat.primary>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
