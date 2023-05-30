<x-filament::widget>
    <x-filament::card>
        <table class="w-full">
            <tr>
                <th class="text-xs text-left">Status</th>
                <th class="text-xs text-right"># Responses</th>
            </tr>
            @foreach ($data as $label => $count)
            <tr>
                <td class="py-1 pr-2">{{ $label }}</td>
                <td class="text-right py-1 pl-2">{{ $count }}</td>
            </tr>
            @endforeach
        </table>
    </x-filament::card>
</x-filament::widget>