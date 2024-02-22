@props([
    'code' => 'Oh no',
    'title',
    'button' => [
        'url' => '/',
        'label' => 'Go home',
    ],

])

<div>
    <section class="bg-green-500">
        <div class="border-b border-green-600 px-8 py-4 md:px-0">
            <div class="container mx-auto">
                <nav class="items-center text-sm font-medium leading-5">
                    <a
                        href="/"
                        class="text-gray-100 transition duration-150 ease-in-out hover:text-white hover:underline"
                    >
                        Home
                    </a>
                </nav>
            </div>
        </div>
        <div class="container mx-auto px-8 py-4 md:px-0">
            <h1 class="text-xl text-white lg:text-4xl">Ope! {{ $code }}</h1>
        </div>
    </section>
    <section class="bg-white py-12 dark:bg-gray-800 md:py-24">
        <div class="mx-auto px-8 md:px-0">
            <div class="prose prose-green mx-auto dark:prose-light">
                <div class="md:text-15xl text-5xl font-black text-black dark:text-gray-100">
                    {{ __($code) }}: {{ __($title) }}
                </div>
                <div class="my-3 h-1 w-16 bg-green-500 md:my-6"></div>

                {{ $slot }}

                <x-bit.button.flat.primary :href="$button['url']">
                    {{ __($button['label']) }}
                </x-bit.button.flat.primary>
            </div>
        </div>
    </section>
</div>
