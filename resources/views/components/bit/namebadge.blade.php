<div {{ $attributes }}>
    <img src="{{ asset('img/name-badge-background.png') }}" class="absolute z-0 w-full" alt="Name Badge Background" />
    <div class="z-10 flex h-full w-full items-center justify-center">
        <div>
            <h1
                id="name"
                class="mb-2 mt-8 text-center text-3xl font-semibold leading-none tracking-wide"
                style="font-family: 'Raleway', sans-serif"
            >
                {{ $ticket->user->name }}
            </h1>
            @if ($ticket->pronouns)
                <p id="pronouns" class="mb-1 text-center text-xl leading-none" style="font-family: 'Lato', sans-serif">
                    {{ $ticket->user->pronouns }}
                </p>
            @endif
        </div>
    </div>
</div>
