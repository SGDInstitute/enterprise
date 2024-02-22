@props([
    'long' => false,
    'data',
])

<table class="w-full">
    <tr>
        <th class="text-left text-xs">Ticket Type</th>
        <th class="text-xs">{{ $long ? 'Unpaid &' : 'X' }} Unfilled</th>
        <th class="text-xs">{{ $long ? 'Unpaid &' : 'X' }} Filled</th>
        <th class="text-xs">{{ $long ? 'Paid &' : '$' }} Unfilled</th>
        <th class="text-xs">{{ $long ? 'Paid &' : '$' }} Filled</th>
    </tr>
    @foreach ($data as $row)
        <tr>
            <td class="py-1 pr-2">{{ $row['ticket-type'] }}</td>
            <td class="px-2 py-1 text-right">{{ $row['unpaid-unfilled'] }}</td>
            <td class="px-2 py-1 text-right">{{ $row['unpaid-filled'] }}</td>
            <td class="py-1 pl-2 text-right">{{ $row['paid-unfilled'] }}</td>
            <td class="py-1 pl-2 text-right">{{ $row['paid-filled'] }}</td>
        </tr>
    @endforeach
</table>
