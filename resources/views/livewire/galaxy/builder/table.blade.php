<x-ui.card>
    <x-ui.card.header title="Rubric">
        <x-bit.button.round.secondary wire:click="addColumn">Add Column</x-bit.button.round.secondary>
        <x-bit.button.round.secondary wire:click="addRow">Add Row</x-bit.button.round.secondary>
    </x-ui.card.header>
    <div class="p-2">
        <x-bit.table>
            <x-slot name="body">
                @foreach ($table as $row => $columns)
                <x-bit.table.row wire:key="row-{{ $row }}">
                    @foreach ($columns as $column => $cell)
                    @if ($row === 0 && $column === 0)
                    <x-bit.table.heading class="text-center" wire:key="row-{{ $row }}-column-{{ $column }}">
                        {{ $cell }}
                    </x-bit.table.heading>
                    @elseif ($row === 0 || $column === 0)
                    <x-bit.table.heading class="relative px-1 py-1" wire:key="row-{{ $row }}-column-{{ $column }}">
                        <x-form.textarea rows="2" class="text-sm" wire:model="table.{{ $row }}.{{ $column }}" />
                        <button type="button" wire:click="smartDelete({{ $row }}, {{ $column }})" class="absolute top-0 right-0 p-2 opacity-5 hover:opacity-100">
                            <x-heroicon-o-trash class="w-4 h-4 text-gray-900 dark:text-gray-200" />
                        </button>
                    </x-bit.table.heading>
                    @else
                    <x-bit.table.cell class="px-1 py-1" wire:key="row-{{ $row }}-column-{{ $column }}">
                        <x-form.textarea rows="1" class="text-sm" wire:model="table.{{ $row }}.{{ $column }}" />
                    </x-bit.table.cell>
                    @endif
                    @endforeach
                </x-bit.table.row>
                @endforeach
            </x-slot>
        </x-bit.table>
    </div>
    <x-ui.card.footer>
        <button wire:click="save" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Save</button>
    </x-ui.card.footer>
</x-ui.card>
