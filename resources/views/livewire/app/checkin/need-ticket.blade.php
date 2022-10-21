<div class="space-y-4">
    <div class="px-4 py-2 text-gray-200 bg-red-500 rounded">
        <p>Looks like there isn't a ticket with that email. If you're sure you have a ticket, please try logging in under a different email.</p>
        <p>If you don't have a ticket you can purchase one.</p>
    </div>

    <div class="flex items-center space-x-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-bit.button.round.primary :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                {{ __('Logout') }}
            </x-bit.button.round.primary>
        </form>
        <x-bit.button.round.primary href="/events">Purchase Ticket</x-bit.button.round.primary>
    </div>
</div>
