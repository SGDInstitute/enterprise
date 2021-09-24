<div class="space-y-8">
    <div class="flex items-center justify-between px-4 py-2 bg-white rounded shadow dark:bg-gray-900">
        <div>
            @foreach($tracks as $track)
            <x-bit.badge>{{ $track->name }}</x-bit.badge>
            @endforeach
        </div>

        <x-bit.button.round.secondary wire:click="openTrackModal">New</x-bit.button.round.secondary>
    </div>

    <div id="calendar-container" wire:ignore>
        <div id="calendar"></div>
    </div>

    <form wire:submit.prevent="saveItem">
        <x-bit.modal.dialog wire:model.defer="showItemModal">
            <x-slot name="title">{{ $editingTrack->id ? 'Create' : 'Edit'}} Item</x-slot>

            <x-slot name="content">
                <div class="space-y-2">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-4">
                        <x-bit.input.group for="editing-item-name" class="md:col-span-3" label="Name">
                            <x-bit.input.text class="w-full mt-1" wire:model="editingItem.name" id="editing-item-name" />
                        </x-bit.input.group>
                        <x-bit.input.group for="editing-item-track" label="Track">
                            <x-bit.input.select class="w-full mt-1" wire:model="editingItem.track_id" id="editing-item-track">
                                    <option value="default" disabled>Select Track</option>
                                @foreach($tracks as $track)
                                    <option value="{{ $track->id }}">{{ $track->name }}</option>
                                @endforeach
                            </x-bit.input.select>
                        </x-bit.input.group>
                    </div>
                    <x-bit.input.group for="editing-item-description" label="Description">
                        <x-bit.input.textarea class="w-full mt-1" wire:model="editingItem.description" id="editing-item-description" />
                    </x-bit.input.group>
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
                <x-bit.button.round.secondary wire:click="resetItemModal">Cancel</x-bit.button.round.secondary>
                <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
            </x-slot>
        </x-bit.modal.dialog>
    </form>

    <form wire:submit.prevent="saveTrack">
        <x-bit.modal.dialog wire:model.defer="showTrackModal">
            <x-slot name="title">{{ $editingTrack->id ? 'Create' : 'Edit'}} Track</x-slot>

            <x-slot name="content">
                <div class="space-y-2">
                    <x-bit.input.group for="editing-name" label="Name">
                        <x-bit.input.text class="w-full mt-1" wire:model="editingTrack.name" id="editing-name" />
                    </x-bit.input.group>
                    <x-bit.input.group for="editing-description" label="Description">
                        <x-bit.input.text class="w-full mt-1" wire:model="editingTrack.description" id="editing-description" />
                    </x-bit.input.group>
                    <x-bit.input.group for="editing-color" label="Color">
                        <x-bit.input.text class="w-full mt-1" wire:model="editingTrack.color" id="editing-color" />
                    </x-bit.input.group>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-bit.button.round.secondary wire:click="resetTrackModal">Cancel</x-bit.button.round.secondary>
                <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
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
