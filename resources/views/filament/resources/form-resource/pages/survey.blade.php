<x-filament::page>
    @foreach ($responses as $qa)
    <x-filament::section collapsible>
        <x-slot name="heading">
            {{ $qa['question']['question'] }}
        </x-slot>

        @if ($qa['question']['type'] === 'list')
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <div class="col-span-2">
                <x-bit.table>
                    <x-slot name="head">
                        <x-bit.table.heading>Option</x-bit.table.heading>
                        <x-bit.table.heading># Chosen</x-bit.table.heading>
                    </x-slot>
                    <x-slot name="body">
                        @foreach ($qa['question']['options'] as $option)
                        <x-bit.table.row wire:key="row-{{ $option }}">
                            <x-bit.table.cell>{{ $option }}</x-bit.table.cell>
                            <x-bit.table.cell>{{ $qa['answers'][$option] ?? 0 }}</x-bit.table.cell>
                        </x-bit.table.row>
                        @endforeach
                        @if (isset($qa['question']['list-other']) && $qa['question']['list-other'])
                        <x-bit.table.row wire:key="row-other">
                            <x-bit.table.cell>Other</x-bit.table.cell>
                            <x-bit.table.cell>{{ $qa['answers']['other'] ?? 0 }}</x-bit.table.cell>
                        </x-bit.table.row>
                        @endif
                    </x-slot>
                </x-bit.table>
            </div>
            @isset($qa['others'])
            <div>
                <h4 class="mb-4 text-lg font-medium text-gray-700 dark:text-gray-300">Other Answers</h4>
                <div class="text-gray-900 dark:text-gray-200">{{ $qa['others'] }}</div>
            </div>
            @endisset
        </div>
        @elseif ($qa['question']['type'] === 'matrix')
        <span>Data was not stored correctly prior to November 11th 😬</span>
        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading></x-bit.table.heading>
                @foreach ($qa['question']['scale'] as $scale)
                    <x-bit.table.heading>{{ $scale }}</x-bit.table.heading>
                @endforeach
            </x-slot>

            <x-slot name="body">
                @foreach ($qa['question']['options'] as $option)
                <x-bit.table.row>
                    <x-bit.table.cell>{{ $option }}</x-bit.table.cell>
                    @foreach ($qa['question']['scale'] as $scale)
                    <x-bit.table.cell>{{ $qa['answers'][$option][$scale] ?? 0 }}</x-bit.table.cell>
                    @endforeach
                </x-bit.table.row>
                @endforeach
            </x-slot>
        </x-bit.table>
        @else
        <ul class="list-disc space-y-2 max-w-prose" style="margin-left: 1em;">
            @foreach ($qa['answers'] as $answer)
            <li>{!! nl2br($answer) !!}</li>
            @endforeach
        </ul>
        @endif
    </x-filament::section>
    @endforeach
</x-filament::page>
