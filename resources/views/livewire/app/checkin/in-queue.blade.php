<div class="mt-8 space-y-4">
    <div class="relative">
        <div class="absolute flex items-center justify-center w-full h-full">
            <div>
                <h1 id="name" class="mt-8 mb-2 text-4xl font-semibold leading-none tracking-wide text-center font-raleway">{{ $user->name }}</h1>
                <p id="pronouns" class="mb-1 font-sans text-2xl leading-none text-center">{{ $user->pronouns }}</p>
            </div>
        </div>
        <img src="{{ asset('img/mblgtacc30-name-badge-blank.jpg') }}" class="w-full" alt="Name Badge Background">

        <div class="absolute flex items-center px-4 py-1 ml-2 space-x-2 text-blue-900 bg-green-500 rounded-l-full shadow -right-1 bottom-4">
            @if ($ticket->isPrinted())
                <p class="font-bold text-center text-gray-700 md:text-xl dark:text-gray-200">Your badge is ready!!</p>
            @else
                <p class="font-bold text-center text-gray-700 md:text-xl dark:text-gray-200">You are checked in and we are preparing your badge.</p>
            @endif
        </div>
    </div>

    <x-bit.alert wire:poll.750ms>We've got {{ $position }} badges to print before yours, please don't come to the desk until you get a notification that your badge is ready.</x-bit.alert>

    <div class="flex justify-center">
        <x-bit.button.flat.secondary size="lg" :href="route('app.program', $ticket->event)">View Virtual Program Book</x-bit.button.flat.secondary>
    </div>
</div>
