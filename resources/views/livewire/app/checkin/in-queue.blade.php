<div class="mt-8 space-y-4">
    <x-name-badge :user="$user">
        <div class="absolute flex items-center px-4 py-2 ml-4 bg-green-500 shadow-[0_6px_2px_-2px_rgba(0,0,0,0.3)] md:ml-8 -right-1 bottom-4 text-gray-200">
            @if ($ticket->isPrinted())
                <p>Your badge is ready!!</p>
            @else
                <p wire:poll.750ms>Please wait for the notification that your badge is ready, and then come to the check-in desk to pick it up.</p>
            @endif
        </div>
    </x-name-badge>

    <div class="flex justify-center">
        <x-bit.button.flat.secondary size="lg" :href="route('app.program', $ticket->event)">View Virtual Program Book</x-bit.button.flat.secondary>
    </div>
</div>
