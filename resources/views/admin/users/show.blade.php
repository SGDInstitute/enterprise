@extends("layouts.admin")

@section('header')
    @component('layouts.components.admin.header')
        <div class="col-lg-10">
            <h2>{{ $user->name }}'s Profile</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin">Dashboard</a>
                </li>
                <li>
                    <a href="/admin/users">Users</a>
                </li>
                <li class="active">
                    <strong>Profile</strong>
                </li>
            </ol>
        </div>
    @endcomponent
@endsection

@section("content")
    <div class="row">
        <div class="col-md-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Profile Detail</h5>
                </div>
                <div>
                    <div class="ibox-content">
                        <img alt="Profile Image" class="img-responsive img-circle pull-left m-r-lg"
                             src="{{ $user->image }}">
                        <h4><strong>{{ $user->name }}</strong></h4>

                        <p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                        <p><b>Joined On:</b> {{ $user->created_at->format('m/d/Y h:i a') }}</p>

                        @can('impersonate')
                            <a href="{{ route('admin.user.impersonate', $user) }}" class="btn btn-default btn-block">
                                <i class="fa fa-user-secret"></i> Impersonate</a>
                        @endcan
                    </div>
                    <div class="ibox-content no-padding">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Pronouns</strong> {{ $user->profile->pronouns }}
                            </li>
                            <li class="list-group-item">
                                <strong>Sexuality</strong> {{ $user->profile->sexuality }}
                            </li>
                            <li class="list-group-item">
                                <strong>Gender</strong> {{ $user->profile->gender }}
                            </li>
                            <li class="list-group-item ">
                                <strong>Race</strong> {{ $user->profile->race }}
                            </li>
                            <li class="list-group-item">
                                <strong>College</strong> {{ $user->profile->college }}
                            </li>
                            <li class="list-group-item">
                                <strong>T-Shirt Size</strong> {{ $user->profile->tshirt}}
                            </li>
                            <li class="list-group-item">
                                <strong>Accommodation</strong> {{ $user->profile->accommodation }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="ibox">
                <div class="ibox-content no-padding">
                    <tabs>
                        <tab name="Orders">
                            <table class="table dataTables">
                                <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Created At</th>
                                    <th>Is Paid</th>
                                    <th>Amount</th>
                                    <th>Tickets</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user->orders as $order)
                                    <tr>
                                        <td>{{ $order->event->title }}</td>
                                        <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                        <td>{{ $order->isPaid() ? 'Yes' : 'No' }}</td>
                                        <td>${{ number_format($order->amount/100, 2) }}</td>
                                        <td>{{ $order->tickets->count() }}</td>
                                        <td class="text-right"><a href="/admin/orders/{{ $order->id }}"
                                                                  class="btn btn-default btn-sm">View Order</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </tab>
                        <tab name="Donations">
                            <table class="table dataTable">
                                <thead>
                                <tr>
                                    <th>Primary Contact</th>
                                    <th>Amount</th>
                                    <th>Donated On</th>
                                    <th>Recurring</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user->donations as $donation)
                                    <tr>
                                        <td>{{ $donation->name }} ({{ $donation->email }})</td>
                                        <td>${{ number_format($donation->amount/100, 2) }}</td>
                                        <td>{{ $donation->created_at->toFormattedDateString() }}</td>
                                        <td>
                                            @if($donation->subscription && $donation->subscription->isActive())
                                                Yes
                                            @elseif($donation->subscription)
                                                Canceled
                                            @else
                                                No
                                            @endif
                                        </td>
                                        <td><a href="/donations/{{ $donation->hash }}">View</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </tab>
                        <tab name="Activity">
                            Third tab content
                        </tab>
                        <tab name="Permissions">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>Roles</td>
                                    <td>
                                        @forelse($user->roles as $role)
                                            <span class="label label-default">{{ str_title($role->name) }}</span>
                                        @empty
                                            N/A
                                        @endforelse
                                    </td>
                                </tr>
                                <tr>
                                    <td>Permissions</td>
                                    <td>
                                        @foreach($user->permissions as $permission)
                                            <span class="label label-default">{{ str_title($permission->name) }}</span>
                                        @endforeach

                                        @foreach($user->roles as $role)
                                            @foreach($role->permissions as $permission)
                                                <span class="label label-info">{{ str_title($permission->name) }}</span>
                                            @endforeach
                                        @endforeach
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </tab>
                    </tabs>
                </div>
            </div>
        </div>
    </div>
@endsection