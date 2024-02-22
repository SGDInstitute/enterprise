<div class="space-y-6">
    <div class="bg-white p-4 text-gray-900 shadow dark:border dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
        Order Owner: {{ $order->user->name }} ({{ $order->user->pronouns }})
        <a class="dar:text-green-400 text-green-500 hover:underline" href="mailto:{{ $order->user->email }}">
            {{ $order->user->email }}
        </a>
    </div>

    <form
        wire:submit="saveTicket"
        class="bg-white p-4 text-gray-900 shadow dark:border dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
    >
        <h2 class="mb-8 text-xl font-bold">Your ticket</h2>

        <div class="space-y-4">
            <x-bit.input.group for="ticketholder-email" label="Email">
                <x-bit.input.text
                    class="mt-1 w-full"
                    type="email"
                    id="ticketholder-email"
                    wire:model.blur="ticketholder.email"
                />
            </x-bit.input.group>
            <x-bit.input.group for="ticketholder-name" label="Name">
                <x-bit.input.text
                    class="mt-1 w-full"
                    type="text"
                    id="ticketholder-name"
                    wire:model.live="ticketholder.name"
                />
            </x-bit.input.group>
            <x-bit.input.group for="ticketholder-pronouns" label="Pronouns">
                <x-bit.input.text
                    class="mt-1 w-full"
                    type="text"
                    id="ticketholder-pronouns"
                    wire:model.live="ticketholder.pronouns"
                />
            </x-bit.input.group>

            @if ($ticket !== null && $ticket->ticketType->form)
                @foreach ($ticket->ticketType->form as $item)
                    @include('livewire.app.forms.partials.' . $item['style'])
                @endforeach
            @endif

            <p class="text-gray-700 dark:text-gray-400">
                By clicking save you agree to the policies and code for inclusion listed
                <span class="hidden lg:inline">to the left</span>
                <span class="lg:hidden">above</span>
                .
            </p>

            <x-bit.button.flat.primary type="submit">Save</x-bit.button.flat.primary>
        </div>
    </form>
</div>
