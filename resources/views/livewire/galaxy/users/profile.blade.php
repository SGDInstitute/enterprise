<div class="grid grid-cols-1 gap-4 mt-8 md:gap-8 md:grid-cols-5">
    <form wire:submit.prevent="save" class="flex flex-col justify-between overflow-hidden bg-white rounded-lg shadow md:col-span-3 dark:bg-gray-700">
        <div class="px-4 py-5 sm:p-6">
            <x-bit.input.group for="user-name" :error="$errors->first('user.name')" label="Name" inline borderless>
                <x-bit.input.text wire:model.lazy="user.name" id="user-name" autocomplete="off" />
            </x-bit.input.group>
            <x-bit.input.group class="mt-4 md:mt-0" for="user-email" :error="$errors->first('user.email')" label="Email" inline borderless>
                <x-bit.input.text wire:model.lazy="user.email" id="user-email" autocomplete="off" />
            </x-bit.input.group>
        </div>
        <div class="px-4 py-4 bg-gray-100 dark:bg-gray-500 sm:px-6">
            <div class="space-x-4 text-sm leading-5">
                @if($profileChanged)
                <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
                <x-bit.badge>Unsaved Changes</x-bit.badge>
                @else
                <x-bit.button.round.primary type="submit" disabled>Save</x-bit.button.round.primary>
                @endif
            </div>
        </div>
    </form>
    <div class="md:space-y-4 md:col-span-2">
        <div class="flex flex-col justify-between bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="px-4 py-4 bg-gray-100 rounded-t-lg dark:bg-gray-500 sm:px-6">
                <div class="flex items-center justify-between leading-5">
                    <h2 class="dark:text-gray-300">Roles</h2>
                    <x-galaxy.help.roles />
                </div>
            </div>
            <div class="px-4 py-5 sm:p-4">
                <ul class="ml-8 list-disc">
                    @forelse($userRoles as $role)
                    <li class="dark:text-gray-200">
                        <div class="flex items-center space-x-4 group">
                            <span>{{ $role->name }}</span>
                            <x-bit.button.link type="button" wire:click="removeRole('{{ $role->name }}')">
                                <x-heroicon-o-trash class="w-4 h-4 text-blue-500 transition-opacity duration-300 opacity-0 group-hover:opacity-100" />
                            </x-bit.button.link>
                        </div>
                    </li>
                    @empty
                    <li class="dark:text-gray-400">
                        <span class="py-8 italic font-medium text-gray-500 dark:text-gray-400 glacial">No Roles for this User</span>
                    </li>
                    @endforelse
                </ul>
            </div>
            <div class="px-4 py-4 bg-gray-100 rounded-b-lg dark:bg-gray-500 sm:px-6">
                <form wire:submit.prevent="addRole" class="text-sm leading-5">
                    <x-bit.input.group for="new-role" label="Role" class="flex" srOnly>
                        <x-bit.input.select wire:model="newRole" id="new-role" placeholder="Select Role..." class="w-full rounded-r-none">
                            @foreach($roles as $id => $value)
                                <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </x-bit.input.select>
                        <x-bit.button.round.secondary type="submit" class="-ml-px rounded-l-none">Add</x-bit.button.round.secondary>
                    </x-bit.input.group>
                </form>
            </div>
        </div>
    </div>
    <div class="md:col-span-2">
        <form wire:submit.prevent="newPassword" class="flex flex-col justify-between overflow-hidden bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="px-4 py-5 sm:p-6">
                <x-bit.input.group for="user-password" label="New Password" :error="$errors->first('password')" inline borderless>
                    <x-bit.input.text type="password" wire:model.lazy="password" id="user-password" autocomplete="off" />
                </x-bit.input.group>
                <x-bit.input.group for="password_confirmation" label="Confirm Password" :error="$errors->first('password_confirmation')" inline borderless>
                    <x-bit.input.text type="password" wire:model.lazy="password_confirmation" id="password_confirmation" autocomplete="off" />
                </x-bit.input.group>
            </div>
            <div class="px-4 py-4 bg-gray-100 dark:bg-gray-500 sm:px-6">
                <div class="space-x-4 text-sm leading-5">
                    @if($passwordChanged)
                    <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
                    <x-bit.badge>Unsaved Changes</x-bit.badge>
                    @else
                    <x-bit.button.round.primary type="submit" disabled>Save</x-bit.button.round.primary>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
