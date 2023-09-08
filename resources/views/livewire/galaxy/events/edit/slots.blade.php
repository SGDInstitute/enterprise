<div class="space-y-8">
    <nav class="flex" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-4">
            <li>
                <div>
                    <a href="/galaxy" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                        <x-heroicon-s-home class="flex-shrink-0 w-5 h-5" />
                        <span class="sr-only">Home</span>
                    </a>
                </div>
            </li>

            <li>
                <div class="flex items-center">
                    <x-heroicon-s-chevron-right class="flex-shrink-0 w-5 h-5 text-gray-400" />
                    <a href="/galaxy/events/{{ $event->id }}/program-schedule" class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">Schedule</a>
                </div>
            </li>

            <li>
                <div class="flex items-center">
                    <x-heroicon-s-chevron-right class="flex-shrink-0 w-5 h-5 text-gray-400" />
                    <a href="{{ url()->current() }}" class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200" aria-current="page">{{ $item->name }}</a>
                </div>
            </li>
        </ol>
    </nav>

    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
        <div class="sm:col-span-1">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Time Slot
            </dt>
            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-200">
                {{ $item->formattedDuration }}
            </dd>
        </div>
        <div class="sm:col-span-1">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Description
            </dt>
            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-200">
                {{ $item->description ?? '-' }}
            </dd>
        </div>
    </dl>

    <div class="space-y-2">
        <div class="md:flex md:justify-between">
            <div></div>
            <div class="flex items-end mt-4 md:mt-0">
                <x-bit.button.round.secondary wire:click="openItemModal" class="flex items-center space-x-2">
                    <x-heroicon-o-plus class="w-4 h-4 text-gray-400 dark:text-gray-300" /> <span>Create</span>
                </x-bit.button.round.secondary>
            </div>
        </div>

        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading>Location</x-bit.table.heading>
                <x-bit.table.heading>Name</x-bit.table.heading>
                <x-bit.table.heading>Tracks</x-bit.table.heading>
                <x-bit.table.heading>Description</x-bit.table.heading>
                <x-bit.table.heading />
            </x-slot>

            <x-slot name="body">
                @forelse ($items as $subItem)
                <x-bit.table.row wire:key="row-{{ $subItem->id }}">
                    <x-bit.table.cell class="flex items-end space-x-4">
                        @if ($editingItem !== null && $editingItem->id === $subItem->id && $showItemModal === false)
                        <form wire:submit="saveLocation">
                            <x-bit.input.text wire:model.live="editingItem.location" />
                        </form>
                        @else
                        <button class="appearance-none" wire:click="setLocation({{ $subItem->id }})">
                            {{ $subItem->location ?? '?' }}
                        </button>
                        @endif

                        @isset($collisions[$subItem->location])
                        <span>
                            <x-heroicon-o-exclamation class="w-4 h-4 text-red-500" />
                        </span>
                        @endisset
                    </x-bit.table.cell>
                    <x-bit.table.cell><span title="{{ $subItem->name }}">{{ $subItem->shortName ?? '?' }}</span></x-bit.table.cell>
                    <x-bit.table.cell>{{ $subItem->tracks ?? '?' }}</x-bit.table.cell>
                    <x-bit.table.cell><span title="{{ $subItem->description }}">{{ $subItem->shortDescription ?? '?' }}</span></x-bit.table.cell>
                    <x-bit.table.cell>
                        <x-bit.button.link size="py-1 px-2" wire:click="openItemModal({{ $subItem->id }})">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                    </x-bit.table.cell>
                </x-bit.table.row>
                @empty
                <x-bit.table.row>
                    <x-bit.table.cell colspan="9">
                        <div class="flex items-center justify-center space-x-2">
                            <x-heroicon-o-calendar class="w-8 h-8 text-gray-400" />
                            <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 ">No sub items found...</span>
                        </div>
                    </x-bit.table.cell>
                </x-bit.table.row>
                @endforelse
            </x-slot>
        </x-bit.table>

        <div class="p-4 mx-auto rounded-md md:w-2/5 bg-blue-50 dark:bg-blue-900">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <x-heroicon-s-information-circle class="w-6 h-6 text-blue-400 dark:text-blue-200" />
                </div>
                <div class="flex-1 ml-3 md:flex md:justify-between">
                    <p class="text-sm text-blue-700 dark:text-blue-300">
                        Quickly add/edit a location by clicking the location cell content, enter the information and hit enter.
                    </p>
                </div>
            </div>
        </div>
    </div>


    <form wire:submit="saveItem">
        <x-bit.modal.dialog wire:model="showItemModal">
            <x-slot name="title">Create/Edit Item</x-slot>

            <x-slot name="content">
                <div class="space-y-2">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-5">
                        <x-bit.input.group for="editing-item-name" class="md:col-span-3" label="Name">
                            <x-bit.input.text class="w-full mt-1" wire:model.live="editingItem.name" id="editing-item-name" />
                        </x-bit.input.group>
                        <x-bit.input.group for="editing-item-location" class="md:col-span-2" label="Location">
                            <x-bit.input.text class="w-full mt-1" wire:model.live="editingItem.location" id="editing-item-location" />
                        </x-bit.input.group>
                    </div>
                    <x-bit.input.group for="editing-tracks" label="Tracks">
                        <x-bit.input.text class="w-full mt-1" wire:model.live="editingTracks" id="editing-tracks" />
                        <x-bit.input.help>Can be separated by comma</x-bit.input.help>
                    </x-bit.input.group>
                    <x-bit.input.group for="editing-item-warnings" label="Content Warnings">
                        <x-bit.input.text class="w-full mt-1" wire:model.live="editingWarnings" id="editing-item-warnings" />
                        <x-bit.input.help>Can be separated by comma</x-bit.input.help>
                    </x-bit.input.group>
                    <x-bit.input.group for="editing-item-speaker" label="Speaker">
                        <x-bit.input.text class="w-full mt-1" wire:model.live="editingItem.speaker" id="editing-item-speaker" />
                    </x-bit.input.group>
                    <x-bit.input.group for="editing-item-description" label="Description">
                        <x-bit.input.textarea rows="8" class="w-full mt-1" wire:model.live="editingItem.description" id="editing-item-description" />
                    </x-bit.input.group>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-bit.button.round.secondary wire:click="resetItemModal">Cancel</x-bit.button.round.secondary>
                <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
            </x-slot>
        </x-bit.modal.dialog>
</div>
