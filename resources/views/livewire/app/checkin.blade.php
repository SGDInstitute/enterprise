<div class="px-4 py-12 mx-auto space-y-8 max-w-prose">
    <h1 class="text-4xl font-bold text-center text-gray-700 dark:text-gray-100">Checkin for {{ $ticket->event->name }}</h1>

    <div class="space-y-2">
        <div class="relative w-full h-64 bg-white shadow-md dark:bg-gray-200 lg:h-96">
            @if($ticket->isQueued())
            <div class="absolute top-0 left-0 z-30 p-2 -mt-4 -ml-4 bg-green-500 rounded-full">
                <x-heroicon-o-check class="w-8 h-8 text-white" />
            </div>
            @endif
            <img src="{{ asset('img/name-badge-background-top.png') }}" class="absolute w-full" alt="Name Badge Background">
            <div class="flex items-center justify-center w-full h-full">
                @if($editing)
                <div>
                    <label for="editing-name" class="sr-only">Name</label>
                    <input id="editing-name" wire:model="user.name" class="block mt-8 mb-2 text-3xl font-semibold leading-none tracking-wide text-center" placeholder="name" />

                    <label for="editing-pronouns" class="sr-only">Pronouns</label>
                    <input id="editing-pronouns" wire:model="user.pronouns" class="block w-full mb-1 text-xl leading-none text-center" placeholder="pronouns" />
                </div>
                @else
                <div>
                    <h1 id="name" class="mt-8 mb-2 text-3xl font-semibold leading-none tracking-wide text-center font-raleway">{{ $user->name }}</h1>
                    @if($user->pronouns)
                    <p id="pronouns" class="mb-1 font-sans text-xl leading-none text-center">{{ $user->pronouns }}</p>
                    @endif
                </div>
                @endif
            </div>
            <div title="We'll send you a notification using this email when your name badge is ready" class="absolute flex items-center w-full py-1 pl-4 space-x-2 text-blue-900 bg-blue-300 rounded-l-full shadow lg:w-2/3 -right-1 bottom-4">
                <label for="editing-email">Notification Email:</span>
                @if($editing)
                <input id="editing-email" wire:model="user.email" class="leading-none" placeholder="email" />
                @else
                <span>{{ $user->email }}</span>
                @endif
            </div>
        </div>
        <div class="space-x-2 text-center">
            @if($ticket->isQueued())
            <div class="space-y-4">
                <p class="text-xl font-bold text-center text-gray-700 dark:text-gray-200">You are checked in and we are preparing your badge.</p>

                <x-bit.button.round.primary size="lg" :href="route('app.program', $ticket->event)">View Virtual Program Book</x-bit.button.round.primary>
            </div>
            @elseif($editing)
            <x-bit.button.round.primary wire:click="save">Save Changes</x-bit.button.round.primary>
            @else
            <x-bit.button.round.primary wire:click="add">Looks Good</x-bit.button.round.primary>
            <x-bit.button.round.secondary wire:click="$set('editing', true)">Something Needs to Change</x-bit.button.round.secondary>
            @endif
        </div>
    </div>
</div>
