@extends("layouts.admin")

@section("content")
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    {{ $event->title }}
                </div>
                <div class="ibox-content">
                    <dl class="dl-horizontal">
                        <dt>Title</dt>
                        <dd>{{ $event->title }}</dd>
                        <dt>Subtitle</dt>
                        <dd>{{ $event->subtitle }}</dd>
                        <dt>Description</dt>
                        <dd>{{ $event->description }}</dd>
                        <dt>Location</dt>
                        <dd>{{ $event->location }}</dd>
                        <dt>Slug</dt>
                        <dd>{{ $event->slug }}</dd>
                        <dt>Stripe</dt>
                        <dd>{{ $event->stripe }}</dd>
                        <dt>Start</dt>
                        <dd>{{ $event->formattedStart }}</dd>
                        <dt>End</dt>
                        <dd>{{ $event->formattedEnd }}</dd>
                        <dt>Published At</dt>
                        <dd>{{ $event->published_at }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection