<div class="mt-8 space-y-4">
    <x-name-badge :user="$user">
        <div class="absolute flex items-center px-4 py-1 ml-2 space-x-2 text-blue-900 bg-green-500 rounded-l-full shadow -right-1 bottom-4">
            @if ($ticket->isPrinted())
                <p class="font-bold text-center text-gray-700 md:text-xl dark:text-gray-200">Your badge is ready!!</p>
            @else
                <p class="font-bold text-center text-gray-700 md:text-xl dark:text-gray-200">You are checked in and we are preparing your badge.</p>
            @endif
        </div>
    </x-name-badge>

    <x-bit.alert wire:poll.750ms>We've got {{ $position }} badges to print before yours, please don't come to the desk until you get a notification that your badge is ready.</x-bit.alert>

    <div class="flex justify-center">
        <x-bit.button.flat.secondary size="lg" :href="route('app.program', $ticket->event)">View Virtual Program Book</x-bit.button.flat.secondary>
    </div>
</div>
