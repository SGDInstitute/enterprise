<div>
    <form wire:submit.prevent="login">
        <x-bit.modal.dialog wire:model="loginModal" max-width="sm">
            <x-slot name="title">Login</x-slot>

            <x-slot name="content">
                <div class="space-y-2">
                    <x-form.group label="Email" model="form.email" type="email" autocomplete="email" />
                    <x-form.group label="Password" model="form.password" type="password" autocomplete="password" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-bit.button.link wire:click="swap('forgotModal')">Forgot Password?</x-bit.button.link>
                <x-bit.button.flat.secondary size="xs" wire:click="$set('loginModal', false)">Close</x-bit.button.flat.secondary>
                <x-bit.button.flat.primary size="xs" type="submit">Login</x-bit.button.flat.primary>
            </x-slot>
        </x-bit.modal.dialog>
    </form>

    <form wire:submit.prevent="forgot">
        <x-bit.modal.dialog wire:model="forgotModal" max-width="sm">
            <x-slot name="title">Forgot</x-slot>

            <x-slot name="content">
                <div class="space-y-2">
                    <p class="text-sm text-gray-600 dark:text-gray-200">Forgot your password? No problem. Enter your email address and we'll send you a link to reset your password.</p>
                    <x-form.group label="Email" model="form.email" type="email" autocomplete="email" />

                    @if($sent)
                    <p class="text-sm text-gray-600 dark:text-gray-200">We have emailed your password reset link.</p>
                    <p class="text-sm text-gray-600 dark:text-gray-200">Follow the instructions in your email to reset your password and log in. Once you do, refresh this page. All of your progress will be saved.</p>
                    @endif
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-bit.button.flat.primary size="xs" type="submit">Email Password Reset Link</x-bit.button.flat.primary>
            </x-slot>
        </x-bit.modal.dialog>
    </form>
</div>
