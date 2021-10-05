<div class="container max-w-6xl p-4 mx-auto md:pb-12 md:pt-6 md:px-0">
    @if(!$checkedIn)
    <div class="p-4 mb-8 bg-green-600 rounded-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <x-heroicon-s-information-circle class="w-6 h-6 text-white" />
            </div>
            <div class="flex-1 ml-3 md:flex md:justify-between">
                <p class="text-gray-200 text">
                    You aren't checked in yet. Please do so we can print your name badge and prepare your swag.
                </p>
                <p class="mt-3 text md:mt-0 md:ml-6">
                    <a href="{{ route('app.checkin', $ticket) }}" class="font-medium text-gray-200 whitespace-nowrap hover:text-white">Check in <span aria-hidden="true">&rarr;</span></a>
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
