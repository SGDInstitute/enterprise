<div class="space-y-8">
    <div id="calendar-container" wire:ignore>
        <div id="calendar"></div>
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
                var start = info.event.start.toISOString().slice(0, 16).replace('T',' ');
                var end = info.event.end.toISOString().slice(0, 16).replace('T',' ')
                @this.changeItemDateTime(info.event.id, start, end);
            },
            eventDrop(info) {
                var start = info.event.start.toISOString().slice(0, 16).replace('T',' ');
                var end = info.event.end.toISOString().slice(0, 16).replace('T',' ')
                @this.changeItemDateTime(info.event.id, start, end);
            }
        });

        calendar.addEventSource( {
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
