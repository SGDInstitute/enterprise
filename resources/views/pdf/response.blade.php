<h1>{{ $response->form->name }}</h1>

<dl>
    <dt>Email</dt>
    <dd><a href="mailto:{{ $response->email }}">{{ $response->email }}</a></dd>

    @foreach($response->responses as $name => $field)
        <dt style="padding-top: 15px">{{ $form->where('id',$name)->first()['question'] }}</dt>
        <dd style="padding-top: 5px">
            @if(is_array($field) && isset($field[0]) && is_array($field[0]))
                @foreach($field as $n => $f)
                    @foreach($f as $k => $v)
                        <strong style="padding-top: 5px">{{ str_title($k) }}:</strong> {{ $v }}<br>
                    @endforeach
                @endforeach
            @elseif(is_array($field))
                {{ implode(', ', $field) }}
            @else
                {{ $field }}
            @endif
        </dd>
    @endforeach
</dl>