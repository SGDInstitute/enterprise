<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="absolute bottom-8 flex h-1/2 w-full items-center justify-center">
        <div>
            <h1 id="name" class="mb-2 text-center font-raleway text-4xl font-semibold leading-none tracking-wide">
                {{ $user->name }}
            </h1>
            <p id="pronouns" class="mb-1 text-center font-sans text-2xl leading-none">{{ $user->pronouns }}</p>
        </div>
    </div>
    <img
        src="{{ $event->getFirstMediaUrl('name_badge') ?? asset('img/mblgtacc30-name-badge-blank.jpg') }}"
        class="w-full"
        alt="Name Badge Background"
    />

    {{ $slot }}
</div>
