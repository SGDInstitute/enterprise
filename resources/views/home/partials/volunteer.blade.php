<div class="bg-white rounded shadow overflow-hidden">
    <nav class="bg-mint-200 flex px-8 pt-2 border-b border-mint-300">
        <h1 class="no-underline text-mint-600 border-b-2 border-mint-600 uppercase tracking-wide font-bold text-xs py-3 mr-8">Your Volunteer Opportunities</h1>
    </nav>
    <div class="p-6 overflow-scroll">
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
                    <td>{{ $activity->location->title }}</td>
                    <td>
                        {{ $activity->start->timezone('America/Detroit')->format('F j, Y') }}<br />
                        {{ $activity->start->timezone('America/Detroit')->format('g:i a') }} - {{ $activity->end->timezone('America/Detroit')->format('g:i a') }}
                    </td>
                    <td class="text-right">
                        {{ $activity->users->count() }} of
                        {{ $activity->spots }}
                    </td>
                    <td>
                        @if($activity->users->count() >= $activity->spots)
                        <button type="button" class="btn btn-mint btn-sm" disabled>Sign Up</button>
                        @elseif($activity->users->firstWhere('id', auth()->id()))
                        <add-to-schedule id="{{ $activity->id }}" class="btn btn-mint-outline btn-sm">Remove</add-to-schedule>
                        @else
                        <add-to-schedule id="{{ $activity->id }}" class="btn btn-mint btn-sm">Sign Up</add-to-schedule>
                        @endif
                    </td>
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