<div>
    <x-bit.nav.tabs :options="$pages" :action="$action" class="mb-8" />

    @switch($page)
        @case('details')
            <livewire:galaxy.events.edit.details :event="$event" />

            @break
        @case('tabs')
            <livewire:galaxy.events.edit.tabs :event="$event" />

            @break
        @case('media')
            <livewire:galaxy.events.edit.media :event="$event" />

            @break
        @case('tickets')
            <livewire:galaxy.events.edit.tickets :event="$event" />

            @break
        @case('addons')
            <livewire:galaxy.events.edit.addons :event="$event" />

            @break
        @case('workshops')
            <livewire:galaxy.events.edit.workshop-form :event="$event" />

            @break
        @case('settings')
            <livewire:galaxy.events.edit.settings :event="$event" />

            @break
        @case('program-schedule')
            <livewire:galaxy.events.edit.schedule :event="$event" />

            @break
        @case('program-bulletin')
            <livewire:galaxy.events.edit.bulletin :event="$event" />

            @break
        @case('program-support')
            <livewire:galaxy.events.edit.support :event="$event" />

            @break
    @endswitch
</div>
