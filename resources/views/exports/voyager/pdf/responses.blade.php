<style>
    .page-break {
        page-break-after: always;
    }
</style>

<h1>{{ $form->name }}</h1>

@foreach($form->responses as $response)
    <div class="page-break"></div>
    <dl>
        @foreach($form->form as $question)
            <dt style="padding-top: 15px">{{ $question['question'] }}</dt>
            <dd style="padding-top: 5px">
                @if(isset($response->responses[$question['id']]) && is_array($response->responses[$question['id']]))
                    @foreach($response->responses[$question['id']] as $item)
                        @if(is_array($item))
                            {{ implode($item) }}
                        @else
                            {{ $item }}@if (!$loop->last), @endif
                        @endif
                    @endforeach
                @else
                    {{ $response->responses[$question['id']] ?? '' }}
                @endif
            </dd>
        @endforeach
    </dl>
@endforeach