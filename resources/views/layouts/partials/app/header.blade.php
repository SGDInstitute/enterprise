<header class="header">
    <nav class="navbar navbar-expand fixed-top navbar-light bg-light">
        <div class="container">
            @if(isset($event))
                <a class="navbar-brand" href="/">{{ $event->title }}</a>
            @endif
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    @if(isset($event))
                        <li class="nav-item"><a class="nav-link" target="_blank" href="{{ $event->links['website'] }}">Event
                                Website</a></li>
                    @endif

                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#"
                               id="navbarDropdownMenuLink" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    {{--<nav class="navbar navbar-default navbar-fixed-top">--}}
    {{--<div class="container">--}}
    {{--<div class="navbar-header">--}}
    {{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"--}}
    {{--data-target="#navbar-collapse" aria-expanded="false">--}}
    {{--<span class="sr-only">Toggle navigation</span>--}}
    {{--<span class="icon-bar"></span>--}}
    {{--<span class="icon-bar"></span>--}}
    {{--<span class="icon-bar"></span>--}}
    {{--</button>--}}
    {{--@if(isset($event))--}}
    {{--<a class="navbar-brand" href="/">{{ $event->title }}</a>--}}
    {{--@endif--}}
    {{--</div>--}}

    {{--<div class="collapse navbar-collapse" id="navbar-collapse">--}}
    {{--<ul class="nav navbar-nav navbar-right">--}}
    {{--@if(isset($event))--}}
    {{--<li><a class="navbar-link" target="_blank" href="{{ $event->links['website'] }}">Event--}}
    {{--Website</a></li>--}}
    {{--@endif--}}

    {{--@guest--}}
    {{--<li><a href="{{ route('login') }}">Login</a></li>--}}
    {{--<li><a href="{{ route('register') }}">Register</a></li>--}}
    {{--@else--}}
    {{--<li class="dropdown">--}}
    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"--}}
    {{--aria-expanded="false">--}}
    {{--{{ Auth::user()->name }} <span class="caret"></span>--}}
    {{--</a>--}}

    {{--<ul class="dropdown-menu" role="menu">--}}
    {{--<li>--}}
    {{--<a href="{{ route('logout') }}"--}}
    {{--onclick="event.preventDefault();--}}
    {{--document.getElementById('logout-form').submit();">--}}
    {{--Logout--}}
    {{--</a>--}}

    {{--<form id="logout-form" action="{{ route('logout') }}" method="POST"--}}
    {{--style="display: none;">--}}
    {{--{{ csrf_field() }}--}}
    {{--</form>--}}
    {{--</li>--}}
    {{--</ul>--}}
    {{--</li>--}}
    {{--@endguest--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</nav>--}}
</header>
