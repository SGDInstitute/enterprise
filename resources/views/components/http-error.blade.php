@props(['code' => 'Oh no', 'title', 'button' => ['url' => '/', 'label' => 'Go home']])

<div>
    <section class="bg-green-500">
        <div class="px-8 py-4 border-b border-green-600 md:px-0">
            <div class="container mx-auto">
                <nav class="items-center text-sm font-medium leading-5 ">
                    <a href="/" class="text-gray-100 transition duration-150 ease-in-out hover:text-white hover:underline">Home</a>
                </nav>
            </div>
        </div>
        <div class="container px-8 py-4 mx-auto md:px-0">
            <h1 class="text-xl text-white lg:text-4xl">Ope! {{ $code }}</h1>
        </div>
    </section>
    <section class="py-12 md:py-24 bg-white dark:bg-gray-800">
        <div class="px-8 mx-auto md:px-0">
            <div class="prose prose-green dark:prose-light mx-auto">
                <div class="text-black dark:text-gray-100 text-5xl md:text-15xl font-black">
                    {{ __($code) }}: {{ __($title) }}
                </div>
                <div class="w-16 h-1 bg-green-500 my-3 md:my-6"></div>

                {{ $slot }}

                <x-bit.button.flat.primary :href="$button['url']">
                    {{ __($button['label']) }}
                </x-bit.button.flat.primary>
            </div>
        </div>
    </section>
</div>