@if($links)
    <div class="{{ $class ?? '' }}">
        @foreach($links as $link)
            @if($link['icon'] === 'website')
                <a href="{{ $link['link'] }}" target="_blank" class="text-mint-700 hover:text-mint-900" aria-label="Website">
                    <i class="fa fa-fw fa-external-link" aria-label="Website"></i>
                </a>
            @else
                <a href="{{ $link['link'] }}" target="_blank" class="text-mint-700 hover:text-mint-900" aria-label="{{ $link['icon'] }}">
                    <i class="fab fa-fw fa-{{ $link['icon'] }}" aria-label="{{ $link['icon'] }}"></i>
                </a>
            @endif
        @endforeach

        {{ $slot }}
    </div>
@endif