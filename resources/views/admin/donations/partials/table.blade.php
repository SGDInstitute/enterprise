<table class="table dataTables">
    <thead>
    <tr>
        <th>Actions</th>
        <th>User</th>
        <th>Amount</th>
        <th>Group</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @forelse($donations as $donation)
        <tr>
            <td>
                <a href="{{ route('admin.donations.show', $donation) }}" class="btn btn-default btn-sm">View</a>
            </td>
            <td>
                @if($donation->user)
                    <a href="{{ route('admin.users.show', $donation->user) }}">{{ $donation->name }}</a>
                    <span class="hidden">{{ $donation->user->email }}</span>
                @else
                    {{ $donation->name }}
                @endif
                <span class="hidden">{{ $donation->email }}</span>
            </td>
            <td class="text-right">
                ${{ number_format($donation->amount/100, 2) }}
                @if($donation->subscription)
                    / {{ $donation->subscription->frequency }}
                @endif
            </td>
            <td>{{ strtoupper($donation->group) }}</td>
            <td>{{ $donation->created_at->format('m/d/y h:i') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No one time donations at this point</td>
        </tr>
    @endforelse
    </tbody>
</table>