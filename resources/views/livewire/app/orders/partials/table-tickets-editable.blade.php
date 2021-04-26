<x-bit.table>
    <x-slot name="head">
        <x-bit.table.heading>Type</x-bit.table.heading>
        <x-bit.table.heading>Email</x-bit.table.heading>
        <x-bit.table.heading>Name</x-bit.table.heading>
        <x-bit.table.heading>Pronouns</x-bit.table.heading>
        <x-bit.table.heading />
    </x-slot>

    <x-slot name="body">
        @forelse($tickets as $index => $ticket)
        <x-bit.table.row wire:key="row-{{ $ticket->id }}">
            <x-bit.table.cell class="pt-1 pb-1">
                <span title="{{ $ticket->ticketType->name }} - {{ $ticket->price->name }}">...</span>
            </x-bit.table.cell>
            <x-bit.table.cell class="pt-1 pb-1">
                <x-bit.input.group :for="'ticket-email-'.$index" label="Email for Ticket {{ $index+1}}" sr-only>
                    <x-bit.input.text :id="'ticket-email-'.$index" placeholder="Email" type="email" wire:model.lazy="form.{{$index}}.email" />
                </x-bit.input.group>
            </x-bit.table.cell>
            <x-bit.table.cell class="pt-1 pb-1">
                <x-bit.input.text placeholder="Name" type="text" wire:model="form.{{$index}}.name" />
            </x-bit.table.cell>
            <x-bit.table.cell class="pt-1 pb-1">
                <x-bit.input.text placeholder="Pronouns" type="text" wire:model="form.{{$index}}.pronouns" />
            </x-bit.table.cell>
            <x-bit.table.cell />
        </x-bit.table.row>
        @empty
        <x-bit.table.row>
            <x-bit.table.cell colspan="9">
                <div class="flex items-center justify-center space-x-2">
                    <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                    <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 glacial">No tickets found...</span>
                </div>
            </x-bit.table.cell>
        </x-bit.table.row>
        @endforelse
    </x-slot>
</x-bit.table>
