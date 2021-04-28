<div>
    <div class="bg-center bg-cover h-1/2-screen" style="background-image: url({{ $image }})"></div>
    <div class="py-6 bg-white dark:bg-gray-800 h-1/4">
        <div class="container px-4 mx-auto md:px-12">
            <div class="md:grid md:grid-cols-5">
                <div class="relative col-span-4 p-8 -mt-24 bg-white dark:bg-gray-800">
                    <h1 class="text-4xl font-bold leading-none text-green-500 lg:text-7xl font-raleway md:text-6xl dark:text-green-200">{{ $title }}</h1>
                </div>
            </div>
            <div class="grid grid-cols-1 px-8 mt-1 mb-8 space-y-4 md:grid-cols-4">
                <div class="md:col-span-3">
                    <p class="text-xl text-gray-600 dark:text-gray-400">{{ $location }}</p>
                    <p class="text-xl text-gray-600 dark:text-gray-400">{{ $dates }}</p>
                </div>
                <!-- Link to tickets ? -->
            </div>
        </div>
    </div>
</div>
