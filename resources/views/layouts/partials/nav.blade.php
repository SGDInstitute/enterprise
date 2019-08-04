<nav class="flex items-center justify-between flex-wrap bg-gray-300 p-6 fixed top-0 w-full z-10 shadow">
    @if(isset($event))
        <a href="{{ Auth::guest() ? '/' : '/home' }}">
            @if(isset($event->logo_dark))
                <img src="{{ Storage::url($event->logo_dark) }}" alt="{{ $event->title }} Logo" class="img-fluid"
                     width="265px">
            @else
                {{ $event->title }}
            @endif
        </a>
    @else
        <a href="{{ Auth::guest() ? '/' : '/home' }}">
            <img src="{{ asset('img/logo.png') }}" width="265px" alt="Institute Logo">
        </a>
    @endif
    <div class="block lg:hidden">
        <button class="flex items-center px-3 py-2 border rounded text-gray-800 border-teal-400 hover:text-white hover:border-white">
            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
            </svg>
        </button>
    </div>
    <div class="w-full hidden lg:flex lg:items-center lg:w-auto">
        <a class="block mt-4 lg:inline-block lg:mt-0 text-gray-800 hover:text-gray-900 hover:underline mr-4"
           href="{{ Auth::guest() ? '/' : '/home' }}">Home</a>
        @if(isset($event))
            <a class="block mt-4 lg:inline-block lg:mt-0 text-gray-800 hover:text-gray-900 hover:underline mr-4"
               target="_blank"
               href="{{ collect($event->links)->where('icon', 'website')->first()['link'] }}">Event Website</a>
        @endif

        @guest
            <a class="block mt-4 lg:inline-block lg:mt-0 text-gray-800 hover:text-gray-900 hover:underline mr-4"
               href="{{ route('login') }}">Login</a>
            <a class="block mt-4 lg:inline-block lg:mt-0 text-gray-800 hover:text-gray-900 hover:underline"
               href="{{ route('register') }}">Create an Account</a>
        @else
            @can('view_dashboard')
                <a class="block mt-4 lg:inline-block lg:mt-0 text-gray-800 hover:text-gray-900 hover:underline"
                   href="/nova">Nova</a>
            @endcan
            {{--            <li class="nav-item dropdown">--}}
            {{--                <a class="nav-link dropdown-toggle" href="#"--}}
            {{--                   id="navbarDropdownMenuLink" data-toggle="dropdown"--}}
            {{--                   aria-haspopup="true" aria-expanded="false">--}}
            {{--                    {{ Auth::user()->name }}--}}
            {{--                </a>--}}
            {{--                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
            {{--                    @if (session('sgdinstitute:impersonator'))--}}
            {{--                        <a class="dropdown-item" href="/users/stop-impersonating">--}}
            {{--                            <i class="fa fa-fw fa-btn fa-user-secret"></i>Back To My Account--}}
            {{--                        </a>--}}
            {{--                    @endif--}}

            {{--                    @if(Auth::user()->hasRole('view_dashboard'))--}}
            {{--                        <a class="dropdown-item" href="/admin"><i class="fa fa-key"></i> Admin Portal</a>--}}
            {{--                    @endif--}}

            {{--                    <a class="dropdown-item" href="/settings">Settings</a>--}}
            {{--                    <a class="dropdown-item" href="{{ route('logout') }}"--}}
            {{--                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">--}}
            {{--                        Logout--}}
            {{--                    </a>--}}

            {{--                    <form id="logout-form" action="{{ route('logout') }}" method="POST"--}}
            {{--                          style="display: none;">--}}
            {{--                        {{ csrf_field() }}--}}
            {{--                    </form>--}}
            {{--                </div>--}}
            {{--            </li>--}}
        @endguest
    </div>
</nav>