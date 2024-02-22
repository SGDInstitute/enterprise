<table class="w-full">
    <tr>
        <th class="text-left text-xs">Ticket Type</th>
        <th class="text-right text-xs">Unpaid</th>
        <th class="text-right text-xs">Paid</th>
    </tr>
    @foreach ($data as $row)
        <tr>
            <td class="py-1 pr-2">{{ $row['ticket-type'] }}</td>
            <td class="px-2 py-1 text-right">{{ $row['reservations'] }}</td>
            <td class="py-1 pl-2 text-right">{{ $row['orders'] }}</td>
        </tr>
    @endforeach
</table>
