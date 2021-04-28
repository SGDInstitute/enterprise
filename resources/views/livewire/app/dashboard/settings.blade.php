<div>
    <h1 class="text-2xl text-gray-900 dark:text-gray-200">Settings</h1>
    <div class="mt-8 space-y-6">
        <div class="px-4 py-5 bg-gray-100 shadow dark:bg-gray-700 sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h1 class="text-2xl font-medium leading-6 text-gray-900 dark:text-gray-200">Profile</h1>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form wire:submit.prevent="save" class="space-y-6">
                        <div class="grid grid-cols-3 gap-6">
                            <x-bit.input.group for="name" class="col-span-3 sm:col-span-2" label="Name" :error="$errors->first('user.name')">
                                <x-bit.input.text class="w-full mt-1" id="name" name="name" type="text" wire:model="user.name" />
                            </x-bit.input.group>
                        </div>

                        <div class="grid grid-cols-3 gap-6">
                            <x-bit.input.group for="email" class="col-span-3 sm:col-span-2" label="Email" :error="$errors->first('user.email')">
                                <x-bit.input.text class="w-full mt-1" id="email" name="email" type="email" wire:model="user.email" />
                            </x-bit.input.group>
                        </div>

                        <div class="grid grid-cols-3 gap-6">
                            <x-bit.input.group for="pronouns" class="col-span-3 sm:col-span-2" label="Pronouns" :error="$errors->first('user.pronouns')">
                                <x-bit.input.text class="w-full mt-1" id="pronouns" name="pronouns" type="text" wire:model="user.pronouns" />
                            </x-bit.input.group>
                        </div>

                        <x-bit.button.flat.primary type="submit">Save</x-bit.button.flat.primary>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
