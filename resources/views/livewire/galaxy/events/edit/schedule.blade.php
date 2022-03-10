<div class="space-y-8">
    <h2 class="text-xl text-gray-900 dark:text-gray-200">Calendar</h2>
    <div id="calendar-container" wire:ignore>
        <div id="calendar"></div>
    </div>

    <h2 class="text-xl text-gray-900 dark:text-gray-200">List of All Items</h2>

    <div class="space-y-4">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row md:w-1/2">
                <x-bit.input.text type="text" wire:model="filters.search" placeholder="Search..." />
            </div>
            <div class="flex items-end mt-4 md:mt-0">
                <x-bit.data-table.per-page />
            </div>
        </div>

        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading sortable wire:click="sortBy('start')" :direction="$sortField === 'start' ? $sortDirection : null">Duration</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('location')" :direction="$sortField === 'location' ? $sortDirection : null">Location</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">Name</x-bit.table.heading>
                <x-bit.table.heading>Tracks</x-bit.table.heading>
                <x-bit.table.heading>Description</x-bit.table.heading>
                <x-bit.table.heading />
            </x-slot>

            <x-slot name="body">
                @forelse($items as $item)
                <x-bit.table.row wire:key="row-{{ $item->id }}">
                    <x-bit.table.cell>{{ $item->formattedDuration ?? '?' }}</x-bit.table.cell>
                    <x-bit.table.cell class="flex items-end space-x-4">{{ $item->location }}</x-bit.table.cell>
                    <x-bit.table.cell><span title="{{ $item->name }}">{{ $item->shortName ?? '?' }}</span></x-bit.table.cell>
                    <x-bit.table.cell>{{ $item->tracks ?? '?' }}</x-bit.table.cell>
                    <x-bit.table.cell><span title="{{ $item->description }}">{{ $item->shortDescription ?? '?' }}</span></x-bit.table.cell>
                    <x-bit.table.cell>
                        <x-bit.button.link size="py-1 px-2" wire:click="openItemModal({{ $item->id }})">
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

        <div>
            {{ $items->links() }}
        </div>
    </div>

    <form wire:submit.prevent="saveItem">
        <x-bit.modal.dialog wire:model.defer="showItemModal">
            <x-slot name="title">Create/Edit Item</x-slot>

            <x-slot name="content">
                <div class="space-y-2">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-5">
                        <x-bit.input.group for="editing-item-name" class="md:col-span-3" label="Name">
                            <x-bit.input.text class="w-full mt-1" wire:model="editingItem.name" id="editing-item-name" />
                        </x-bit.input.group>
                        <x-bit.input.group for="editing-tracks" class="md:col-span-2" label="Tracks">
                            <x-bit.input.text class="w-full mt-1" wire:model="editingTracks" id="editing-tracks" />
                        </x-bit.input.group>
                    </div>
                    @if($showItemModal)
                    <x-bit.input.group for="editing-item-description" label="Description">
                        <x-bit.input.markdown id="editing-item-description" class="block w-full mt-1" type="text" name="description" wire:model="editingItem.description" />
                    </x-bit.input.group>
                    @endIf
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-4">
                        <x-bit.input.group for="editing-item-start" label="Date" class="md:col-span-2">
                            <x-bit.input.date class="w-full mt-1" wire:model="form.date" id="editing-item-start" />
                        </x-bit.input.group>
                        <x-bit.input.group for="editing-item-start" label="Start">
                            <x-bit.input.time class="w-full mt-1" wire:model="form.start" id="editing-item-start" />
                        </x-bit.input.group>
                        <x-bit.input.group for="editing-item-end" label="End">
                            <x-bit.input.time class="w-full mt-1" wire:model="form.end" id="editing-item-end" />
                        </x-bit.input.group>
                    </div>
                    <x-bit.input.group for="editing-item-location" label="Location">
                        <x-bit.input.text class="w-full mt-1" wire:model="editingItem.location" id="editing-item-location" />
                    </x-bit.input.group>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex items-center justify-between w-full">
                    <div>
                        <x-bit.button.round.secondary wire:click="redirectToSlot">Add Item to Slot</x-bit.button.round.secondary>
                    </div>
                    <div>
                        <x-bit.button.round.secondary wire:click="resetItemModal">Cancel</x-bit.button.round.secondary>
                        <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
                    </div>
                </div>
            </x-slot>
        </x-bit.modal.dialog>
    </form>

</div>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>
<script src="https://unpkg.com/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: '{{ $this->event->timezone }}',
            initialView: 'timeGridThreeDay',
            initialDate: '2021-10-08',
            editable: true,
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'timeGridDay,timeGridThreeDay'
            },
            views: {
                timeGridThreeDay: {
                    slotMinTime: '7:00',
                    type: 'timeGrid',
                    duration: {
                        days: 3
                    },
                    buttonText: '{{ $start->diffInDays($end) + 1 }} day'
                }
            },
            dateClick(info) {
                @this.openItemModal(info.date);
            },
            eventClick(info) {
                @this.openItemModal(info.event.id);
            },
            eventResize(info) {
                var start = info.event.start.toISOString().slice(0, 16).replace('T', ' ');
                var end = info.event.end.toISOString().slice(0, 16).replace('T', ' ')
                @this.changeItemDateTime(info.event.id, start, end);
            },
            eventDrop(info) {
                var start = info.event.start.toISOString().slice(0, 16).replace('T', ' ');
                var end = info.event.end.toISOString().slice(0, 16).replace('T', ' ')
                @this.changeItemDateTime(info.event.id, start, end);
            }
        });

        calendar.addEventSource({
            url: '/api/events/{{ $event->id }}/schedule'
        });

        calendar.render();

        @this.on(`refreshCalendar`, () => {
            calendar.refetchEvents()
        });
    });
</script>
@endpush

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
@endpush
