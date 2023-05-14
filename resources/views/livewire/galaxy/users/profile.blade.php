<div class="grid grid-cols-1 gap-4 mt-8 md:gap-8 md:grid-cols-5">
    <div class="space-y-8 md:col-span-3">
        <x-bit.panel title="Profile">
            <form wire:submit.prevent="save">
                <x-bit.panel.body class="space-y-4">
                    <x-form.group model="user.name" label="Name" type="text" />
                    <x-form.group model="user.email" label="Email" type="email" />
                    <x-form.group model="user.pronouns" label="Pronouns" type="text" />

                    <div class="space-y-4">
                        @if ($profileChanged)
                            <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
                            <x-ui.badge>Unsaved Changes</x-ui.badge>
                        @else
                            <x-bit.button.round.primary type="submit" disabled>Save</x-bit.button.round.primary>
                        @endif
                    </div>
                </x-bit.panel.body>
            </form>
        </x-bit.panel>

        <x-bit.panel title="Address">
            <form wire:submit.prevent="save">
                <x-bit.panel.body class="space-y-4">
                    <x-form.address wire:model="user.address" />

                    <div class="space-y-4">
                        @if ($addressChanged)
                            <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
                            <x-ui.badge>Unsaved Changes</x-ui.badge>
                        @else
                            <x-bit.button.round.primary type="submit" disabled>Save</x-bit.button.round.primary>
                        @endif
                    </div>
                </x-bit.panel.body>
            </form>
        </x-bit.panel>
    </div>

    <div class="space-y-8 md:col-span-2">
        <x-bit.panel title="Password">
            <form wire:submit.prevent="newPassword">
                <x-bit.panel.body class="space-y-4">
                    <x-form.group model="password" label="New Password" type="password" />
                    <x-form.group model="password_confirmation" label="Confirm Password" type="password" />

                    <div class="space-y-4">
                        @if ($passwordChanged)
                            <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
                            <x-ui.badge>Unsaved Changes</x-ui.badge>
                        @else
                            <x-bit.button.round.primary type="submit" disabled>Save</x-bit.button.round.primary>
                        @endif
                    </div>
                </x-bit.panel.body>
            </form>
        </x-bit.panel>

        <x-bit.panel>
            <form wire:submit.prevent="addRole">
                <x-bit.panel.heading class="flex items-center justify-between">
                    <h2 class="dark:text-gray-300">Roles</h2>
                    <x-galaxy.help.roles />
                </x-bit.panel.heading>
                <x-bit.panel.body class="space-y-4">
                    <ul class="ml-8 list-disc">
                        @forelse ($userRoles as $role)
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
                            <span class="py-8 italic font-medium text-gray-500 dark:text-gray-400 ">No Roles for this User</span>
                        </li>
                        @endforelse
                    </ul>

                    <form wire:submit.prevent="addRole" class="text-sm leading-5">
                        <x-bit.input.group for="new-role" label="Role" class="flex" srOnly>
                            <x-bit.input.select wire:model="newRole" id="new-role" placeholder="Select Role..." class="w-full rounded-r-none">
                                @foreach ($roles as $id => $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            </x-bit.input.select>
                            <x-bit.button.round.secondary type="submit" class="-ml-px rounded-l-none">Add</x-bit.button.round.secondary>
                        </x-bit.input.group>
                    </form>
                </x-bit.panel.body>
            </form>
        </x-bit.panel>
    </div>
</div>
