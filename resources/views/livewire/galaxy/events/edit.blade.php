<div>
    <x-bit.nav.tabs :options="$pages" class="mb-8" />

    @switch($page)
    @case('details')
    <livewire:galaxy.events.edit.details :event="$event" />
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

    @case('settings')
    <livewire:galaxy.events.edit.settings :event="$event" />
    @break
    @endswitch
</div>
