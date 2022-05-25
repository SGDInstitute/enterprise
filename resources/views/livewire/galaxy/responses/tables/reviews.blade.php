<x-bit.table>
    <x-slot name="head">
        <x-bit.table.heading>Reviewer</x-bit.table.heading>
        <x-bit.table.heading>Workshop</x-bit.table.heading>
        @foreach ($form->settings->get('searchable', []) as $label)
        <x-bit.table.heading>{{ str_replace(['question', '_', '-'], '', $label) }}</x-bit.table.heading>
        @endforeach
        <x-bit.table.heading>Created At</x-bit.table.heading>
        <x-bit.table.heading />
    </x-slot>

    <x-slot name="body">
        @forelse ($responses as $response)
        <x-bit.table.row wire:key="row-{{ $response->id }}">
            <x-bit.table.cell>{{ $response->user->name }}</x-bit.table.cell>
            <x-bit.table.cell>{{ $response->parent->name }}</x-bit.table.cell>
            @foreach ($form->settings->get('searchable', []) as $item)
            <x-bit.table.cell>
                @if (is_array($response->answers[$item]))
                    {{ implode(', ', $response->answers[$item]) }}
                @elseif (!empty($response->answers[$item]))
                    {{ $response->answers[$item] ?? '?' }}
                @else
                    ?
                @endif
            </x-bit.table.cell>
            @endforeach
            <x-bit.table.cell>{{ $response->created_at->format('M, d Y') }}</x-bit.table.cell>
            <x-bit.table.cell>
                <x-bit.button.link size="py-1 px-2" href="{{ route('galaxy.responses.show', ['response' => $response]) }}">
                    <x-heroicon-o-eye class="w-4 h-4 text-green-500 dark:text-green-400" />
                </x-bit.button.link>
            </x-bit.table.cell>
        </x-bit.table.row>
        @empty
        <x-bit.table.row>
            <x-bit.table.cell colspan="9">
                <div class="flex items-center justify-center space-x-2">
                    <x-heroicon-o-document class="w-8 h-8 text-gray-400" />
                    <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 ">No reviews found...</span>
                </div>
            </x-bit.table.cell>
        </x-bit.table.row>
        @endforelse
    </x-slot>
</x-bit.table>
