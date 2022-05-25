<x-bit.table>
    <x-slot name="head">
        <x-bit.table.heading>Status</x-bit.table.heading>
        @forelse ($form->settings->get('searchable', []) as $label)
        <x-bit.table.heading>{{ str_replace(['question', '_', '-'], '', $label) }}</x-bit.table.heading>
        @empty
        <x-bit.table.heading>Workshop</x-bit.table.heading>
        @endforelse
        @if ($form->review)
        <x-bit.table.heading># Reviews</x-bit.table.heading>
        <x-bit.table.heading>Avg. Score</x-bit.table.heading>
        @endif
        <x-bit.table.heading>Created At</x-bit.table.heading>
        <x-bit.table.heading />
    </x-slot>

    <x-slot name="body">
        @forelse ($responses as $response)
        <x-bit.table.row wire:key="row-{{ $response->id }}">
            <x-bit.table.cell>
                <span>{{ $response->status }}</span>
                @if (isset($assignedWorkshops[$response->id]))
                <x-bit.button.link size="py-1 px-2" wire:click="editItem({{ $assignedWorkshops[$response->id] }})">
                    <x-heroicon-o-pencil class="w-4 h-4 text-green-500 dark:text-green-400" />
                </x-bit.button.link>
                @elseif ($response->status === 'approved' && $event->items->count() > 0)
                <x-bit.button.link size="py-1 px-2" wire:click="assignTime({{ $response->id }})">
                    <x-heroicon-o-calendar class="w-4 h-4 text-green-500 dark:text-green-400" />
                </x-bit.button.link>
                @endif
            </x-bit.table.cell>
            @forelse ($form->settings->get('searchable', []) as $item)
            <x-bit.table.cell>
                @if (is_array($response->answers[$item]))
                    {{ implode(', ', $response->answers[$item]) }}
                @elseif (!empty($response->answers[$item]))
                    {{ $response->answers[$item] ?? '?' }}
                @else
                    ?
                @endif
            </x-bit.table.cell>
            @empty
            <x-bit.table.cell>{{ $response->name }}</x-bit.table.cell>
            @endforelse
            @if ($form->review)
            <x-bit.table.cell>{{ $response->reviews->count() }}</x-bit.table.cell>
            <x-bit.table.cell>{!! $response->reviews->count() > 0 ? $response->score : '-' !!}</x-bit.table.cell>
            @endif
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
                    <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 ">No responses for form found...</span>
                </div>
            </x-bit.table.cell>
        </x-bit.table.row>
        @endforelse
    </x-slot>
</x-bit.table>
