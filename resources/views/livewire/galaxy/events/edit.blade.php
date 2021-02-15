<div>
    <x-bit.nav.tabs :options="$pages" class="mb-8" />

    @switch($page)
    @case('details')
    <livewire:galaxy.events.details :event="$event" />
    @break

    @case('media')
    <livewire:galaxy.events.media :event="$event" />
    @break

    @case('media')
    <livewire:galaxy.events.tickets :event="$event" />
    @break

    @case('media')
    <livewire:galaxy.events.addons :event="$event" />
    @break

    @case('settings')
    <livewire:galaxy.events.settings :event="$event" />
    @break
    @endswitch


</div>
