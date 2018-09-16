@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header')
            @yield('header-title')
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © 2018 <a href="https://sgdinstitute.org" target="_blank">Midwest Institute for Sexuality and Gender Diversity</a> | PO Box 1053, East Lansing, MI, 48826 | <a href="mailto:webmaster@sgdinstitute.org" target="_blank">Contact</a> | <a href="https://sgdinstitute.org" target="_blank">sgdinstitute.org</a>
        @endcomponent
    @endslot
@endcomponent
