<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <img alt="image" class="img-responsive" src="/img/enterprise.png"/>
                    </span>
                    <div class="m-t-sm">
                        <span class="pull-left m-r-sm">
                            <img alt="image" class="img-circle" width="48px" src="{{ Auth::user()->image }}"/>
                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <strong class="font-bold">{{ Auth::user()->name }}</strong>
                                    <span class="text-muted text-xs"><b class="caret"></b></span>
                                </span>
                            </span>
                        </a>
                        <ul class="dropdown-menu animated fadeIn m-t-xs">
                            <li><a href="profile">Profile</a></li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="logo-element">
                    SGD
                </div>
            </li>
            <li>
                <a href="#"><i class="fa fa-calendar"></i> <span class="nav-label">Events </span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="#">View All</a></li>
                    @foreach($events as $event)
                        <li>
                            <a href="#" id="damian">{{ $event->title }} <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="/admin/events/{{ $event->slug }}">View Event</a>
                                </li>
                                <li>
                                    <a href="/admin/events/{{ $event->slug }}/orders">View Orders</a>
                                </li>
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-magic"></i> <span class="nav-label">Top Level Item </span></a>
            </li>
            <li class="landing_link">
                <a target="_blank" href="https://sgdinstitute.org/"><i class="fa fa-star"></i> <span class="nav-label">Website</span></a>
            </li>
        </ul>
    </div>
</nav>