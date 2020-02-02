<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SGD Institute Genesis</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400|Raleway:700&display=swap" rel="stylesheet">

</head>

<body>

    @foreach($tickets as $ticket)
    <div style="page-break-after: always;">
        <img src="{{ asset('img/name-badge-background.png') }}" class="absolute z-0 w-full" alt="Name Badge Background">
        <div class="h-screen w-full flex items-center justify-center z-10">
            <div>
                <h1 id="name" class="text-center text-3xl font-semibold leading-none mb-2 tracking-wide mt-8" style="font-family: 'Raleway', sans-serif;">{{ $ticket->name }}</h1>
                @if($ticket->pronouns)
                <p id="pronouns" class="text-xl text-center leading-none mb-1" style="font-family: 'Lato', sans-serif;">{{ $ticket->pronouns }}</p>
                @endif
                @if($ticket->college)
                <p id="college" class="text-xl text-center" style="font-family: 'Lato', sans-serif;">{{ $ticket->college }}</p>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    <script>
        // window.print();
    </script>
</body>

</html>