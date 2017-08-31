@if($links)
    <div class="social-links">
        @foreach($links as $link)
            @if($link['icon'] === 'website')
                <a href="{{ $link['link'] }}" target="_blank">
                    <i class="fa fa-external-link" aria-label="External Link"></i>
                </a>
            @else
                <a href="{{ $link['link'] }}" target="_blank">
                    <i class="fa fa-{{ $link['icon'] }}" aria-label="{{ $link['icon'] }}"></i>
                </a>
            @endif
        @endforeach

        {{ $slot }}
    </div>
@endif