@extends("layouts.admin")

@section("content")
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    Application Users
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table dataTables">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined On</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->name }}
                                        @foreach($user->roles as $role)
                                            <span class="label label-default">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('m/d/Y') }}</td>
                                    <td class="text-right">
                                        <a href="/admin/users/{{ $user->id }}" class="btn btn-default btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @can('impersonate')
                                            <a href="/admin/users/{{ $user->id }}/impersonate"
                                               class="btn btn-default btn-xs">
                                                <i class="fa fa-user-secret"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        No users at this point.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection