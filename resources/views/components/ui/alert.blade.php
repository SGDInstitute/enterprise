<div class="sticky top-20 z-50 mx-auto mb-8 max-w-prose" {{ $attributes }}>
    <div class="rounded-md bg-green-600 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <x-heroicon-s-information-circle class="h-8 w-8 text-gray-200" />
            </div>
            <div class="ml-3 flex-1 md:flex md:justify-between">
                <p class="text-lg text-gray-200">
                    {{ $slot }}
                </p>
            </div>
        </div>
    </div>
</div>
