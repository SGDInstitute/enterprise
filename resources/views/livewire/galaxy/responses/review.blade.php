<div class="pt-6 space-y-6 border-t border-gray-100 dark:border-gray-700">
    @foreach($tracks as $index => $track)
    <h3 class="mb-4 text-lg text-gray-900 dark:text-gray-200">Review for Track: {{ $track }}</h3>
    <x-bit.table>
        <x-slot name="body">
            @foreach ($rubric->form as $row => $columns)
            <x-bit.table.row wire:key="row-{{ $row }}">
                @foreach ($columns as $column => $cell)
                @if($row === 0 || $column === 0)
                <x-bit.table.heading class="text-center">
                    {{ $cell }}
                </x-bit.table.heading>
                @elseif ($rubric->form[0][$column] === 'Notes')
                <x-bit.table.cell class="px-1 py-1">
                    <x-form.textarea class="text-sm" wire:model="reviews.{{ $index }}.{{ $row }}.notes" />
                </x-bit.table.cell>
                @elseif ($rubric->form[0][$column] === 'Help')
                <x-bit.table.cell class="px-1 py-1">
                    {!! markdown($cell) !!}
                </x-bit.table.cell>
                @else
                <x-bit.table.cell class="px-1 py-1">
                    <x-form.radio :label="$cell" :value="$rubric->form[0][$column]" id="reviews.{{ $index }}.{{ $row }}.points" name="reviews.{{ $index }}.{{ $row }}.points" wire:model="reviews.{{ $index }}.{{ $row }}.points" />
                </x-bit.table.cell>
                @endif
                @endforeach
            </x-bit.table.row>
            @endforeach
        </x-slot>
    </x-bit.table>
    @endforeach
    <button wire:click="save" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Save</button>
<div>
