<div class="space-y-8">
    <h1 class="text-2xl text-gray-900 dark:text-gray-200">Invitations</h1>

    <div class="space-y-8">

        @if (! $verified)
            <x-ui.alert>
            You must <a href="{{ route('verification.notice') }}" class="font-bold text-white underline">verify your email</a> before accepting invitations.
            </x-ui.alert>
        @endif

        @foreach($invitations as $invitation)
        <div class="bg-white dark:bg-gray-800 shadow flex items-center justify-between p-4 space-x-4">
            <div class="flex items-center space-x-4">
                @if ($invitation->inviteable_type === App\Models\Ticket::class)
                <x-heroicon-o-ticket class="w-12 h-12 text-gray-500" />
                <div>
                    <p class="text-gray-900 dark:text-gray-200">Ticket for {{ $invitation->inviteable->event->name }}</p>
                    <p class="text-gray-700 dark:text-gray-400">Invited by {{ $invitation->inviter->name }}</p>
                </div>
                @elseif ($invitation->inviteable_type === App\Models\Response::class)
                <x-heroicon-o-light-bulb class="w-12 h-12 text-gray-500"/>
                <div>
                    <p class="text-gray-900 dark:text-gray-200">Presenter for {{ $invitation->inviteable->name }}</p>
                    <p class="text-gray-700 dark:text-gray-400">Invited by {{ $invitation->inviter->name }}</p>
                </div>
                @endif
            </div>
            @if($verified)
            <x-bit.button.flat.primary :href="$invitation->acceptUrl">Accept Invite</x-bit.button.flat.primary>
            @else
            <x-bit.button.flat.primary disabled>Accept Invite</x-bit.button.flat.primary>
            @endif
        </div>
        @endforeach
    </div>
</div>
