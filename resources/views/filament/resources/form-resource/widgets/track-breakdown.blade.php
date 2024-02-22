<x-filament::widget>
    <x-filament::section>
        <table class="w-full">
            <tr>
                <th class="text-left text-xs">Track</th>
                <th class="text-right text-xs">First Choice</th>
                <th class="text-right text-xs">Second Choice</th>
            </tr>
            @foreach ($data as $label => $counts)
                <tr>
                    <td class="py-1 pr-2">{{ $label }}</td>
                    <td class="px-2 py-1 text-right">{{ $counts[0] }}</td>
                    <td class="py-1 pl-2 text-right">{{ $counts[1] }}</td>
                </tr>
            @endforeach
        </table>
    </x-filament::section>
</x-filament::widget>
