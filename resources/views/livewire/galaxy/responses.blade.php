<div>
    <div x-data="{ show: false }">
        <x-bit.button.round.primary @click="show = !show">Send Notification</x-bit.button.round.primary>
        <x-bit.button.round.primary wire:click="downloadSchedule">Download Schedule</x-bit.button.round.primary>
        <div
            x-show="show"
            x-cloak
            x-transition:enter="transform transition duration-100 ease-out"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transform transition duration-75 ease-in"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0"
        >
            <form wire:submit="sendNotifications" class="flex items-end space-x-4 py-4">
                <x-form.group
                    model="notification.type"
                    type="select"
                    label="Notification"
                    placeholder="Choose notification"
                    :options="['finalize' => 'Finalize Program Book Details']"
                />
                <x-form.group
                    model="notification.status"
                    type="select"
                    label="Status"
                    placeholder="Choose status"
                    :options="$statusOptions"
                />
                <x-bit.button.round.primary size="lg" type="submit">Send</x-bit.button.round.primary>
            </form>
        </div>
    </div>

    <div class="mt-5 flex-col space-y-4" x-data="{ showAdvanced: false }">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:w-1/2 md:flex-row md:items-end md:space-x-4">
                <x-bit.input.text type="text" wire:model.live="filters.search" placeholder="Search Proposals..." />
                @if ($form->settings->searchable)
                    <x-bit.button.link @click="showAdvanced = !showAdvanced">
                        <span x-show="showAdvanced" x-cloak>Hide</span>
                        Advanced Search...
                    </x-bit.button.link>
                @endif
            </div>
            <div class="mt-4 flex items-end md:mt-0">
                <x-bit.data-table.per-page />
            </div>
        </div>

        <!-- Advanced Search -->
        <div
            x-show="showAdvanced"
            x-cloak
            x-transition:enter="transform transition duration-100 ease-out"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transform transition duration-75 ease-in"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0"
        >
            <div class="relative rounded bg-gray-50 p-4 shadow-inner dark:bg-gray-850">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <x-form.group
                        model="advanced.status"
                        type="select"
                        label="Status"
                        placeholder="Choose status"
                        :options="$statusOptions"
                    />
                    @foreach ($advancedSearchForm as $item)
                        @if ($item['type'] === 'text')
                            <x-form.group model="advanced.{{ $item['id'] }}" :label="$item['question']" type="text" />
                        @elseif ($item['type'] === 'list')
                            <x-bit.input.group
                                :for="$item['id']"
                                :label="$item['question']"
                                :error="$errors->first('advanced.' . $item['id'])"
                            >
                                <div class="mt-1 space-y-1">
                                    @foreach ($item['options'] as $key => $label)
                                        @if (strpos($label, ':'))
                                            <x-bit.input.checkbox
                                                :value="explode(':', $label)[0]"
                                                :id="$item['id'].'-'.$key"
                                                :label="explode(':', $label)[0]"
                                                wire:model.live="advanced.{{ $item['id'] }}"
                                            />
                                        @else
                                            <x-bit.input.checkbox
                                                :value="$label"
                                                :id="$item['id'].'-'.$key"
                                                :label="$label"
                                                wire:model.live="advanced.{{ $item['id'] }}"
                                            />
                                        @endif
                                    @endforeach

                                    @if (isset($item['list-other']) && $item['list-other'] === true)
                                        <x-bit.input.checkbox
                                            value="other"
                                            label="Other"
                                            wire:model.live="advanced.{{ $item['id'] }}"
                                        />
                                    @endif
                                </div>
                            </x-bit.input.group>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        @if ($form->type === 'review')
            @include('livewire.galaxy.responses.tables.reviews')
        @elseif ($form->type === 'workshop')
            @include('livewire.galaxy.responses.tables.workshops')
        @else
            @include('livewire.galaxy.responses.tables.default')
        @endif

        <div>
            {{ $responses->links() }}
        </div>
    </div>

    <form wire:submit="saveItem">
        <x-bit.modal.dialog wire:model="showItemModal">
            <x-slot name="title">{{ $editingItem->id !== null ? 'Create' : 'Edit' }} Item</x-slot>

            <x-slot name="content">
                <div class="space-y-2">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-4">
                        <x-bit.input.group for="editing-item-schedule-slot" label="Schedule Slot" class="md:col-span-3">
                            <x-bit.input.select
                                class="mt-1 w-full"
                                wire:model.live="editingItem.parent_id"
                                id="editing-item-schedule-slot"
                            >
                                <option value="default" selected disabled>Select Slot</option>
                                @foreach ($slots as $slot)
                                    <option value="{{ $slot->id }}">{{ $slot->name }}</option>
                                @endforeach
                            </x-bit.input.select>
                        </x-bit.input.group>
                        <x-bit.input.group for="editing-item-location" label="Location">
                            <x-bit.input.text
                                class="mt-1 w-full"
                                wire:model.live="editingItem.location"
                                id="editing-item-location"
                            />
                        </x-bit.input.group>
                    </div>
                    <x-bit.input.group for="editing-item-name" class="md:col-span-3" label="Name">
                        <x-bit.input.text
                            class="mt-1 w-full"
                            wire:model.live="editingItem.name"
                            id="editing-item-name"
                        />
                    </x-bit.input.group>
                    <x-bit.input.group for="editing-item-track" label="Tracks">
                        <x-bit.input.text class="mt-1 w-full" wire:model.live="editingTracks" id="editing-item-track" />
                        <x-bit.input.help>Can be separated by comma</x-bit.input.help>
                    </x-bit.input.group>
                    <x-bit.input.group for="editing-item-speaker" label="Speaker">
                        <x-bit.input.text
                            rows="8"
                            class="mt-1 w-full"
                            wire:model.live="editingItem.speaker"
                            id="editing-item-speaker"
                        />
                    </x-bit.input.group>
                    <x-bit.input.group for="editing-item-description" label="Description">
                        <x-bit.input.textarea
                            rows="8"
                            class="mt-1 w-full"
                            wire:model.live="editingItem.description"
                            id="editing-item-description"
                        />
                    </x-bit.input.group>
                    <x-bit.input.group for="editing-item-warnings" label="Content Warnings">
                        <x-bit.input.text
                            class="mt-1 w-full"
                            wire:model.live="editingWarnings"
                            id="editing-item-warnings"
                        />
                        <x-bit.input.help>Can be separated by comma</x-bit.input.help>
                    </x-bit.input.group>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-bit.button.round.secondary wire:click="resetItemModal">Cancel</x-bit.button.round.secondary>
                <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
            </x-slot>
        </x-bit.modal.dialog>
    </form>
</div>
