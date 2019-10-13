<div class="bg-white rounded shadow overflow-hidden">
    <nav class="bg-mint-200 px-8 pt-2 border-b border-mint-300">
        <div class="-mb-px flex nav nav-tabs material-nav" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="upcoming-tab" data-toggle="tab" href="#submitted" role="tab" aria-controls="submitted" aria-selected="true">Submitted Workshops</a>
            <a class="nav-item nav-link" id="past-tab" data-toggle="tab" href="#open" role="tab" aria-controls="open" aria-selected="false">Open Workshop Forms</a>
        </div>
    </nav>
    <div class="tab-content p-6" id="nav-tabContent">
        <div class="tab-pane fade show active" id="submitted" role="tabpanel" aria-labelledby="submitted-tab">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">Form</th>
                        <th class="text-left">Workshop Name</th>
                        <th class="text-left">Submitted On</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submittedWorkshops as $workshop)
                    <tr>
                        <td>{{ $workshop->form->name }}</td>
                        <td>{{ $workshop->responses['name'] }}</td>
                        <td>{{ $workshop->created_at->format('m/d/Y') }}</td>
                        <td><a href="/responses/{{ $workshop->id }}/edit" class="btn btn-mint btn-sm">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="open" role="tabpanel" aria-labelledby="open-tab">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">Form</th>
                        <th class="text-left">Opend On</th>
                        <th class="text-left">Closes On</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($openWorkshops as $workshop)
                    <tr>
                        <td><a href="/forms/{{ $workshop->slug }}">{{ $workshop->name }}</a></td>
                        <td>{{ $workshop->start->format('m/d/Y') }}</td>
                        <td>{{ $workshop->end->format('m/d/Y') }}</td>
                        <td><a href="/forms/{{ $workshop->slug }}" class="btn btn-mint btn-sm">Submit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>