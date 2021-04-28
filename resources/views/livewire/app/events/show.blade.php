<div>
    <x-bit.event.header :event="$event" />

    <div class="container px-8 pb-12 mx-auto md:px-12">
        <div class="grid grid-cols-1 gap-12 md:grid-cols-3">
            <div class="md:col-span-2">
                <livewire:app.events.tabs :event="$event" />
            </div>
            <div>
                <livewire:app.events.tickets :event="$event" />
            </div>
        </div>
    </div>
</div>
