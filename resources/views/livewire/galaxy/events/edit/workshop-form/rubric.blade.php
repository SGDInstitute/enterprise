<div class="bg-white rounded-md shadow dark:bg-gray-800">
    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 rounded-t-md dark:border-gray-700">
        <h2 class="text-xl text-gray-600 dark:text-gray-400">Rubric</h2>

        <div>
            <x-bit.button.round.secondary wire:click="addColumn">Add Column</x-bit.button.round.secondary>
            <x-bit.button.round.secondary wire:click="addRow">Add Row</x-bit.button.round.secondary>
        </div>
    </div>

    <div class="p-2">
        <x-bit.table>
            <x-slot name="body">
                @foreach ($table as $row => $columns)
                <x-bit.table.row wire:key="row-{{ $row }}">
                    @foreach ($columns as $column => $cell)
                    @if($row === 0 && $column === 0)
                    <x-bit.table.heading class="text-center" wire:key="row-{{ $row }}-column-{{ $column }}">
                        {{ $cell }}
                    </x-bit.table.heading>
                    @elseif ($row === 0 || $column === 0)
                    <x-bit.table.heading class="px-1 py-1" wire:key="row-{{ $row }}-column-{{ $column }}">
                        <x-form.textarea rows="1" class="text-sm" wire:model="table.{{ $row }}.{{ $column }}" />
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
</div>
