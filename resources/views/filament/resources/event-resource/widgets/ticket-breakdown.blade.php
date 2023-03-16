<x-filament::widget>
    <x-filament::card>
        <table class="w-full">
            <tr>
                <th class="text-xs text-left">Ticket Type</th>
                <th class="text-xs text-right">Unpaid</th>
                <th class="text-xs text-right">Paid</th>
            </tr>
            @foreach($this->tablePaidData() as $row)
            <tr>
                <td class="py-1 pr-2">{{ $row['ticket-type'] }}</td>
                <td class="text-right py-1 px-2">{{ $row['reservations'] }}</td>
                <td class="text-right py-1 pl-2">{{ $row['orders'] }}</td>
            </tr>
            @endforeach
        </table>
    </x-filament::card>
    <x-filament::card class="mt-4">
        <table class="w-full">
            <tr>
                <th class="text-xs text-left">Ticket Type</th>
                <th class="text-xs">❌ Unfilled</th>
                <th class="text-xs">❌ Filled</th>
                <th class="text-xs">💰 Unfilled</th>
                <th class="text-xs">💰 Filled</th>
            </tr>
            @foreach($this->tableFilledData() as $row)
            <tr>
                <td class="py-1 pr-2">{{ $row['ticket-type'] }}</td>
                <td class="text-right py-1 px-2">{{ $row['unpaid-unfilled'] }}</td>
                <td class="text-right py-1 px-2">{{ $row['unpaid-filled'] }}</td>
                <td class="text-right py-1 pl-2">{{ $row['paid-unfilled'] }}</td>
                <td class="text-right py-1 pl-2">{{ $row['paid-filled'] }}</td>
            </tr>
            @endforeach
        </table>
    </x-filament::card>
</x-filament::widget>
