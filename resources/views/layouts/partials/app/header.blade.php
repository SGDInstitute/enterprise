<header class="header">
    <nav class="navbar navbar-expand-sm fixed-top navbar-light bg-light">
        <div class="container">
            @if(isset($event))
                <a class="navbar-brand" href="/">
                    @if(isset($event->logo_dark))
                        <img src="{{ $event->logo_dark }}" alt="{{ $event->title }} Logo" class="img-fluid" style="max-width: 35%">
                    @else
                        {{ $event->title }}
                    @endif
                </a>
            @else
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('img/logo.png') }}" width="265px" alt="Institute Logo">
                </a>
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
                                <a class="dropdown-item" href="/settings">Settings</a>
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
</header>
