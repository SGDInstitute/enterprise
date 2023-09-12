<x-filament::widget>
    <x-filament::section>
        <table class="w-full">
            <tr>
                <th class="text-xs text-left">Status</th>
                <th class="text-xs text-right"># Responses</th>
            </tr>
            @foreach ($data as $label => $count)
            <tr>
                <td class="py-1 pr-2">{{ $label }}</td>
                <td class="py-1 pl-2 text-right">{{ $count }}</td>
            </tr>
            @endforeach
        </table>
    </x-filament::section>
</x-filament::widget>