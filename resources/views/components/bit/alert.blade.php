<!-- This example requires Tailwind CSS v2.0+ -->
<div class="p-4 rounded-md bg-blue-50 dark:bg-blue-900">
  <div class="flex">
    <div class="flex-shrink-0">
      <x-heroicon-s-information-circle class="w-5 h-5 text-blue-400 dark:text-blue-500" />
    </div>
    <div class="flex-1 ml-3 md:flex md:justify-between">
      <p class="text-sm text-blue-700 dark:text-blue-300">{{ $slot }}</p>
      @isset($button)
      <p class="mt-3 text-sm md:mt-0 md:ml-6">
          {{ $button }}
          {{-- <a href="#" class="font-medium text-blue-700 whitespace-nowrap hover:text-blue-600">Details <span aria-hidden="true">&rarr;</span></a> --}}
      </p>
      @endif
    </div>
  </div>
</div>
