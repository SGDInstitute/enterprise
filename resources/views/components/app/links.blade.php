@if($links)
    <div class="social-links">
        @foreach($links as $icon => $link)
            @if($icon === 'website')
                <a href="{{ $link }}" target="_blank">
                    <i class="fa fa-external-link" aria-label="External Link"></i>
                </a>
            @else
                <a href="{{ $link }}" target="_blank">
                    <i class="fa fa-{{ $icon }}" aria-label="{{ $icon }}"></i>
                </a>
            @endif
        @endforeach

        {{ $slot }}
    </div>
@endif