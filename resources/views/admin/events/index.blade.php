@extends("layouts.admin")

@section("content")
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    Events
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Timezone</th>
                                    <th>Place</th>
                                    <th>Duration</th>
                                    <th>Stripe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                    <tr>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->timezone }}</td>
                                        <td>{{ $event->place }}, {{ $event->location }}</td>
                                        <td>{{ $event->start->format('M j') }} - {{ $event->end->format('j, Y') }}</td>
                                        <td>{{ $event->stripe }}</td>
                                        <td class="text-right"><a href="/admin/events/{{ $event->slug }}" class="btn btn-default btn-sm">View Event</a></td>
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