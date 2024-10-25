<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="absolute flex items-center justify-center w-full h-1/2 bottom-8">
        <div>
            <h1 id="name" class="mb-2 text-4xl font-semibold leading-none tracking-wide text-center font-sans">{{ $user->name }}</h1>
            <p id="pronouns" class="mb-1 font-sans text-2xl leading-none text-center">{{ $user->pronouns }}</p>
        </div>
    </div>
    <img src="{{ asset('img/mblgtacc2024-name-badge-blank.png') }}" class="w-full" alt="Name Badge Background">

    {{ $slot }}
</div>
