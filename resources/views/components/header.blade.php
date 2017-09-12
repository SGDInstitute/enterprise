<header class="header">
    <!-- Nav -->
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                @if(isset($event))
                    <a class="navbar-brand" href="/">{{ $event->title }}</a>
                @endif
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    @if(isset($event))
                        <li><a class="navbar-link" target="_blank" href="{{ $event->links['website'] }}">Event
                                Website</a></li>
                    @endif
                    <li><a class="navbar-link" href="/login">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>