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
                        <div class="table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Is Paid</th>
                                        <th>Amount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->isPaid() ? 'Yes' : 'No' }}</td>
                                            <td>${{ number_format($order->amount/100, 2) }}</td>
                                            <td class="text-right"><a href="/admin/orders/{{ $order->id }}" class="btn btn-default btn-sm">View Order</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection