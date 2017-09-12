@if($links)
    <div class="social-links {{ $class or '' }}">
        @foreach($links as $link)
            @if($link['icon'] === 'website')
                <a href="{{ $link['link'] }}" target="_blank" aria-label="Website">
                    <i class="fa fa-external-link" aria-label="Website"></i>
                </a>
            @else
                <a href="{{ $link['link'] }}" target="_blank" aria-label="{{ $link['icon'] }}">
                    <i class="fa fa-{{ $link['icon'] }}" aria-label="{{ $link['icon'] }}"></i>
                </a>
            @endif
        @endforeach

        {{ $slot }}
    </div>
@endif