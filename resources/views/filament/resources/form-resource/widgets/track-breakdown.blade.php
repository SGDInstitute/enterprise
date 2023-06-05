<x-filament::widget>
    <x-filament::card>
        <table class="w-full">
            <tr>
                <th class="text-xs text-left">Track</th>
                <th class="text-xs text-right">First Choice</th>
                <th class="text-xs text-right">Second Choice</th>
            </tr>
            @foreach ($data as $label => $counts)
            <tr>
                <td class="py-1 pr-2">{{ $label }}</td>
                <td class="text-right py-1 px-2">{{ $counts[0] }}</td>
                <td class="text-right py-1 pl-2">{{ $counts[1] }}</td>
            </tr>
            @endforeach
        </table>
    </x-filament::card>
</x-filament::widget>
