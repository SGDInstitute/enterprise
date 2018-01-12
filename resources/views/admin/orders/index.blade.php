@extends("layouts.admin")

@section("content")
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    Orders for {{ $event->title }}
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table dataTables">
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
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->created_at }}</td>
                                    <td><a href="{{ url('/admin/users/' . $order->user->id) }}">{{ $order->user->name }}</a></td>
                                    <td><a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a></td>
                                    <td>{{ $order->isPaid() ? 'Yes' : 'No' }}</td>
                                    <td>${{ number_format($order->amount/100, 2) }}</td>
                                    <td>{{ $order->tickets->count() }}</td>
                                    <td>{{ $order->tickets()->filled()->count()/$order->tickets->count()*100 }}% ({{ $order->tickets()->filled()->count() }})</td>
                                    <td class="text-right"><a href="/admin/orders/{{ $order->id }}"
                                                              class="btn btn-default btn-sm">View Order</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection