<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SGD Institute Genesis</title>
    <link href="{{ mix('css/checkin.css') }}" rel="stylesheet">
</head>
<body>

@foreach($tickets as $ticket)
    <div style="page-break-after: always;">
        <img src="{{ asset('img/name-badge-background.png') }}" class="absolute z-0 w-full" alt="Name Badge Background">
        <div class="h-screen w-full flex items-center justify-center z-10">
            <div>
                <h1 id="name" class="text-center mb-2">{{ $ticket->name }}</h1>
                @if($ticket->pronouns)
                    <p id="pronouns" class="text-xl font-semibold text-center mb-2">{{ $ticket->pronouns }}</p>
                @endif
                @if($ticket->college)
                    <p id="college" class="text-center">{{ $ticket->college }}</p>
                @endif
            </div>
        </div>
    </div>
@endforeach

<script>
    window.print();
</script>
</body>
</html>
