@props(['long' => false, 'data'])

<table class="w-full">
    <tr>
        <th class="text-xs text-left">Ticket Type</th>
        <th class="text-xs">{{ $long ? 'Unpaid &' : 'X' }} Unfilled</th>
        <th class="text-xs">{{ $long ? 'Unpaid &' : 'X' }} Filled</th>
        <th class="text-xs">{{ $long ? 'Paid &' : '$' }} Unfilled</th>
        <th class="text-xs">{{ $long ? 'Paid &' : '$' }} Filled</th>
    </tr>
    @foreach($data as $row)
    <tr>
        <td class="py-1 pr-2">{{ $row['ticket-type'] }}</td>
        <td class="text-right py-1 px-2">{{ $row['unpaid-unfilled'] }}</td>
        <td class="text-right py-1 px-2">{{ $row['unpaid-filled'] }}</td>
        <td class="text-right py-1 pl-2">{{ $row['paid-unfilled'] }}</td>
        <td class="text-right py-1 pl-2">{{ $row['paid-filled'] }}</td>
    </tr>
    @endforeach
</table>
