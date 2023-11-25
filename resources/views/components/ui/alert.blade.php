<div class="sticky z-50 mx-auto mb-8 max-w-prose top-20" {{ $attributes }}>
    <div class="p-4 bg-green-600 rounded-md">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <x-heroicon-s-information-circle class="w-8 h-8 text-gray-200" />
            </div>
            <div class="flex-1 ml-3 md:flex md:justify-between">
                <p class="text-lg text-gray-200">
                    {{ $slot }}
                </p>
            </div>
        </div>
    </div>
</div>
