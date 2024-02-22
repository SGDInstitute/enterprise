<div class="rounded-md bg-blue-50 p-4 dark:bg-blue-900">
    <div class="flex">
        <div class="flex-shrink-0">
            <x-heroicon-s-information-circle class="h-5 w-5 text-blue-400 dark:text-blue-500" />
        </div>
        <div class="ml-3 flex-1 md:flex md:justify-between">
            <p class="text-sm text-blue-700 dark:text-blue-300">{{ $slot }}</p>
            @isset($button)
                <p class="mt-3 text-sm md:ml-6 md:mt-0">
                    {{ $button }}
                    {{-- <a href="#" class="font-medium text-blue-700 whitespace-nowrap hover:text-blue-600">Details <span aria-hidden="true">&rarr;</span></a> --}}
                </p>
            @endif
        </div>
    </div>
</div>
