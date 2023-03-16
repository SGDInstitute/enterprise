<table class="w-full">
    <tr>
        <th class="text-xs text-left">Ticket Type</th>
        <th class="text-xs text-right">Unpaid</th>
        <th class="text-xs text-right">Paid</th>
    </tr>
    @foreach($data as $row)
    <tr>
        <td class="py-1 pr-2">{{ $row['ticket-type'] }}</td>
        <td class="text-right py-1 px-2">{{ $row['reservations'] }}</td>
        <td class="text-right py-1 pl-2">{{ $row['orders'] }}</td>
    </tr>
    @endforeach
</table>
