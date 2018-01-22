@extends("layouts.admin")

@section("content")
    <div class="row" style="margin-bottom: 15px">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h1 class="card-title">{{ $orders->count() }} Total Orders</h1>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h1 class="card-title">{{ $event->orders()->paid()->count() }} Paid Orders</h1>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h1 class="card-title">{{ $event->orders()->paid()->get()->flatMap->tickets->count() }} Paid Tickets</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    Orders for {{ $event->title }}

                    <a href="/admin/reports/orders/download" class="pull-right">Download Report</a>
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
                                <th># Tickets Completed</th>
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
                                    <td>
                                        @if($order->tickets->count() > 0)
                                        {{ $order->tickets()->completed()->count()/$order->tickets->count()*100 }}% ({{ $order->tickets()->completed()->count() }})
                                        @endif
                                    </td>
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