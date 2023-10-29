<div>
    <h1 class="text-2xl text-gray-900 dark:text-gray-200">Settings</h1>
    <div class="mt-8 space-y-6">
        <div class="px-4 py-5 bg-white shadow dark:bg-gray-800 sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h2 class="text-2xl font-medium leading-6 text-gray-900 dark:text-gray-200">Profile</h2>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form wire:submit="saveProfile" class="space-y-6">
                        {{ $this->profileForm }}

                        <x-bit.button.flat.primary type="submit">Save</x-bit.button.flat.primary>
                    </form>
                </div>
            </div>
        </div>
        <div class="px-4 py-5 bg-white shadow dark:bg-gray-800 sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h2 class="text-2xl font-medium leading-6 text-gray-900 dark:text-gray-200">Password</h2>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form wire:submit="savePassword" class="space-y-6">
                        {{ $this->passwordForm }}

                        <x-bit.button.flat.primary type="submit">Save</x-bit.button.flat.primary>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
