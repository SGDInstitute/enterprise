<div class="container p-4 mx-auto md:py-12 md:px-0">
    @switch($page)
        @case('bulletin-board')
        <livewire:app.program.bulletin-board :event="$event" />
        @break
        @case('schedule')
        <livewire:app.program.schedule :event="$event" />
        @break
        @case('my-schedule')
        <livewire:app.program.my-schedule :event="$event" />
        @break
        @case('badge')
        <livewire:app.program.badge :event="$event" />
        @break
        @case('contact')
        <livewire:app.program.contact :event="$event" />
        @break
        @case('faq')
        <livewire:app.program.faq :event="$event" />
        @break
    @endswitch
</div>
