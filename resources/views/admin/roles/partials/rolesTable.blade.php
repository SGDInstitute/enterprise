<table class="table dataTables">
    <thead>
    <tr>
        <th>Name</th>
        <th>Permissions</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($roles as $role)
        <tr>
            <td>{{ str_title($role->name) }}</td>
            <td>
                @forelse($role->permissions as $permission)
                    <span class="label label-default">{{ str_title($permission->name) }}</span>
                @empty
                    N/A
                @endforelse
            </td>
            <td>
                <a href="#" class="btn btn-flat btn-warning btn-xs"><i class="fa fa-pencil"></i> Edit</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">
                No roles at this point.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
