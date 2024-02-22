@foreach ($items as $item)
    Name: {!! htmlspecialchars_decode($item->name) !!} Time: {{ $item->formattedDuration }} Speaker:
    {{ $item->speaker }} Location: {{ $item->location }} Description:
    {!! htmlspecialchars_decode($item->description) !!} Track: {{ $item->tracks }} Warnings: {{ $item->warnings }}

    @if ($item->children->isNotEmpty())
        Children:

        @foreach ($item->children as $child)
                Name: {!! htmlspecialchars_decode($child->name) !!} Speaker: {{ $child->speaker }} Location:
                {{ $child->location }} Description: {!! htmlspecialchars_decode($child->description) !!} Track:
                {{ $child->tracks }} Warnings: {{ $child->warnings }}
        @endforeach
    @endif
    -------------------------------------
@endforeach
