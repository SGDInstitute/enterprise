<div class="relative">
    <div class="absolute flex items-center justify-center w-full h-full">
        <div>
            <h1 id="name" class="mt-8 mb-2 text-4xl font-semibold leading-none tracking-wide text-center font-raleway">{{ $user->name }}</h1>
            <p id="pronouns" class="mb-1 font-sans text-2xl leading-none text-center">{{ $user->pronouns }}</p>
        </div>
    </div>
    <img src="{{ asset('img/mblgtacc30-name-badge-blank.jpg') }}" class="w-full" alt="Name Badge Background">

    {{ $slot }}
</div>
