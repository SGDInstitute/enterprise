<div class="mt-8 space-y-4">
    <x-name-badge :user="$user" :event="$event" class="shadow-xl" />

    <div class="space-y-4 bg-white p-6 shadow-md dark:bg-gray-800">
        <div class="prose prose-xl dark:prose-light">
            @if ($ticket->isPrinted())
                <p>Your badge is ready!!</p>
            @else
                <p wire:poll.750ms>
                    Thanks for checking in. You&apos;ll receive a notification when your name badge is ready to pick up.
                    In the meantime, check out the maker market in Ballroom 1 (starting at 5 p.m.) or review the program
                    to pick your sessions.
                </p>
            @endif
        </div>

        <x-bit.button.flat.secondary size="lg" block :href="route('app.program', $ticket->event)">
            View Virtual Program Book
        </x-bit.button.flat.secondary>
    </div>
</div>
