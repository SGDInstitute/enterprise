<table class="table dataTable">
    <thead>
    <tr>
        <th>Created At</th>
        <th>User</th>
        <th>Email</th>
        <th>Is Paid</th>
        <th>Amount</th>
        <th># Tickets</th>
        <th># Tickets Filled</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $order)
        <tr>
            <td><a href="{{ url('/admin/orders/' . $order->id) }}">{{ $order->created_at }}</a></td>
            <td><a href="{{ url('/admin/users/' . $order->user->id) }}">{{ $order->user->name }}</a></td>
            <td><a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a></td>
            <td>{{ $order->isPaid() ? 'Yes' : 'No' }}</td>
            <td>${{ number_format($order->amount/100, 2) }}</td>
            <td>{{ $order->tickets->count() }}</td>
            <td>
                @if($order->tickets->count() > 0)
                {{ $order->tickets()->filled()->count()/$order->tickets->count()*100 }}% ({{ $order->tickets()->filled()->count() }})
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>