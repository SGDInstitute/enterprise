<div class="space-y-6">
    <div class="text-gray-900 dark:text-gray-200 bg-white dark:bg-gray-800 shadow dark:border dark:border-gray-700 p-4">
        Order Owner: {{ $order->user->name }} ({{ $order->user->pronouns }}) <a class="text-green-500 hover:underline dar:text-green-400" href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>
    </div>

    <form wire:submit.prevent="saveTicket" class="text-gray-900 dark:text-gray-200 bg-white dark:bg-gray-800 shadow dark:border dark:border-gray-700 p-4">
        <h2 class="text-xl font-bold mb-8">Your ticket</h2>

        <div class="space-y-4">
            <x-bit.input.group for="ticketholder-email" label="Email">
                <x-bit.input.text class="w-full mt-1" type="email" id="ticketholder-email" wire:model.lazy="ticketholder.email" />
            </x-bit.input.group>
            <x-bit.input.group for="ticketholder-name" label="Name">
                <x-bit.input.text class="w-full mt-1" type="text" id="ticketholder-name" wire:model="ticketholder.name" />
            </x-bit.input.group>
            <x-bit.input.group for="ticketholder-pronouns" label="Pronouns">
                <x-bit.input.text class="w-full mt-1" type="text" id="ticketholder-pronouns" wire:model="ticketholder.pronouns" />
            </x-bit.input.group>
    
            @if ($ticket !== null && $ticket->ticketType->form)
                @foreach ($ticket->ticketType->form as $item)
                    @include('livewire.app.forms.partials.' . $item['style'])
                @endforeach
            @endif

            <p class="text-gray-700 dark:text-gray-400">By clicking save you agree to the policies and code for inclusion listed <span class="hidden lg:inline">to the left</span><span class="lg:hidden">above</span>.</p>

            <x-bit.button.flat.primary type="submit">Save</x-bit.button.flat.primary>
        </div>
    </form>
</div>
