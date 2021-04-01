<div>
    <x-bit.event.header :event="$event" />

    <div class="container px-12 pb-12 mx-auto">
        <div class="grid grid-cols-1 gap-12 md:grid-cols-3">
            <div class="col-span-2">
                <livewire:app.events.tabs :event="$event" />
            </div>
            <div>
                <livewire:app.events.tickets :event="$event" />
            </div>
        </div>
    </div>
</div>
