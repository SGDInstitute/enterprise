<div>
    <div class="h-1/2-screen bg-cover bg-center" style="background-image: url({{ $image }})"></div>
    <div class="h-1/4 bg-white py-6 dark:bg-gray-800">
        <div class="container mx-auto px-4 md:px-12">
            <div class="md:grid md:grid-cols-5">
                <div class="relative col-span-4 -mt-24 bg-white p-8 dark:bg-gray-800">
                    <h1
                        class="font-raleway text-4xl font-bold leading-none text-green-500 dark:text-green-200 md:text-6xl lg:text-7xl"
                    >
                        {{ $title }}
                    </h1>
                </div>
            </div>
            <div class="mb-8 mt-1 grid grid-cols-1 space-y-4 px-8 md:grid-cols-4">
                <div class="md:col-span-3">
                    <p class="text-xl text-gray-600 dark:text-gray-400">{{ $location }}</p>
                    <p class="text-xl text-gray-600 dark:text-gray-400">{{ $dates }}</p>
                </div>
                <!-- Link to tickets ? -->
            </div>
        </div>
    </div>
</div>
