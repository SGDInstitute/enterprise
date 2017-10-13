<table class="table">
    <thead>
    <tr>
        <th class="col-sm-2">Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th>Permissions</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>
            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
            <td>
                @forelse($user->roles as $role)
                    <span class="label label-default">{{ str_title($role->name) }}</span>
                @empty
                    N/A
                @endforelse
            </td>
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
            <td>
                {{--<a href="{{ route('admin.user.access.edit', $user) }}" class="btn btn-default btn-xs">Edit</a>--}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>