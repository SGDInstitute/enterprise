<ul class="ml-4 list-disc">
    @foreach ($this->record->responses()->where('status', $status)->get()->sortBy('name') as $proposal)
    <li>{{ $proposal->name }} <span class="text-sm">by {{ $proposal->collaborators->implode('name') }}</span></li>
    @endforeach
</ul>