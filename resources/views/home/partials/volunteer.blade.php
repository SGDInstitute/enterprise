<div class="bg-white rounded shadow overflow-hidden">
    <nav class="bg-mint-200 flex px-8 pt-2 border-b border-mint-300">
        <h1 class="no-underline text-mint-600 border-b-2 border-mint-600 uppercase tracking-wide font-bold text-xs py-3 mr-8">Your Volunteer Opportunities</h1>
    </nav>
    <div class="p-6">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Duration</th>
                    <th>Spots</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($volunteerActivities as $activity)
                <tr>
                    <td>{{ $activity->title }}</td>
                    <td>{{ $activity->location }}</td>
                    <td>
                        {{ $activity->start->format('F j, Y') }}<br />
                        {{ $activity->start->format('g:i a') }} - {{ $activity->end->format('g:i a') }}
                    </td>
                    <td class="text-right">{{ $activity->spots }}</td>
                    <td><a href="#">Sign Up</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        Looks like there isn't a volunteer schedule yet, check back later!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>