<div class="space-y-4">
    <div class="prose dark:prose-light">
        <h1>Badge</h1>
    </div>

    <div class="relative w-full h-64 bg-white shadow-md dark:bg-gray-200 lg:h-96">
        <img src="{{ asset('img/name-badge-background-top.png') }}" class="absolute w-full" alt="Name Badge Background">
        <div class="flex items-center justify-center w-full h-full">
            <div>
                <h1 id="name" class="mt-8 mb-2 text-3xl font-semibold leading-none tracking-wide text-center font-raleway">{{ $user->name }}</h1>
                @if($user->pronouns)
                <p id="pronouns" class="mb-1 font-sans text-xl leading-none text-center">{{ $user->pronouns }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
