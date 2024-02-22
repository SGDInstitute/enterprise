<div class="container mx-auto mt-8 space-y-8 px-8">
    <div>
        <h1 class="mb-4 text-4xl dark:text-gray-200">Upcoming Events</h1>
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">
            @foreach ($events as $event)
                <x-bit.event :event="$event" />
            @endforeach
        </div>
    </div>

    @if ($workshopForms->isNotEmpty())
        <div>
            <h1 class="mb-4 text-4xl dark:text-gray-200">Workshop Proposals/Call for Papers</h1>
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">
                @foreach ($workshopForms as $form)
                    <x-bit.workshop :form="$form" />
                @endforeach
            </div>
        </div>
    @endif
</div>
