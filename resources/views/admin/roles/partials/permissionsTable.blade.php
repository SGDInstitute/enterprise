<table class="table dataTables" style="width: 100%">
    <thead>
    <tr>
        <th>Name</th>
        <th>Roles</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($permissions as $permission)
        <tr>
            <td>{{ str_title($permission->name) }}</td>
            <td>
                @forelse($permission->roles as $role)
                    <span class="label label-default">{{ str_title($role->name) }}</span>
                @empty
                    N/A
                @endforelse
            </td>
            <td>
                <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">No permissions at this point.</td>
        </tr>
    @endforelse
    </tbody>
</table>
