<div class="container mx-auto max-w-6xl p-4 md:px-0 md:pb-12 md:pt-6">
    @if (! $checkedIn)
        <div class="mb-8 rounded-md bg-green-600 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-heroicon-s-information-circle class="h-6 w-6 text-white" />
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <p class="text text-gray-200">
                        You aren't checked in yet. Please do so we can print your name badge and prepare your swag.
                    </p>
                    <p class="text mt-3 md:ml-6 md:mt-0">
                        <a
                            href="{{ route('app.checkin', $ticket) }}"
                            class="whitespace-nowrap font-medium text-gray-200 hover:text-white"
                        >
                            Check in
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endif

    @switch($page)
        @case('bulletin-board')
            <livewire:app.program.bulletin-board :event="$event" />

            @break
        @case('schedule')
            <livewire:app.program.schedule :event="$event" />

            @break
        @case('virtual-schedule')
            <livewire:app.program.virtual-schedule :event="$event" />

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
