<div {{ $attributes }}>
    <img src="{{ asset('img/name-badge-background.png') }}" class="absolute z-0 w-full" alt="Name Badge Background">
    <div class="z-10 flex items-center justify-center w-full h-full">
        <div>
            <h1 id="name" class="mt-8 mb-2 text-3xl font-semibold leading-none tracking-wide text-center" style="font-family: 'Raleway', sans-serif;">{{ $ticket->user->name }}</h1>
            @if ($ticket->pronouns)
            <p id="pronouns" class="mb-1 text-xl leading-none text-center" style="font-family: 'Lato', sans-serif;">{{ $ticket->user->pronouns }}</p>
            @endif
        </div>
    </div>
</div>
