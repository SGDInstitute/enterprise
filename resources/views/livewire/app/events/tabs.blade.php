<div>
    <div>
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Select a tab</label>
            <select id="tabs" wire:model="$active" name="tabs" class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                @foreach($options as $option)
                <option>{{ $option }}</option>
                @endforeach
            </select>
        </div>
        <div class="hidden sm:block">
            <div class="border-b border-gray-200 dark:border-gray-600">
                <nav class="flex -mb-px space-x-8" aria-label="Tabs">
                    @foreach($options as $option)
                    @if($option === $active)
                    <button wire:click="setActive('{{$option}}')" class="px-1 py-4 text-sm font-bold text-green-500 border-b-2 border-green-500 dark:text-green-400 dark:border-green-400 whitespace-nowrap">
                        {{ $option }}
                    </button>
                    @else
                    <button wire:click="setActive('{{$option}}')" class="px-1 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 whitespace-nowrap">
                        {{ $option }}
                    </button>
                    @endif

                    @endforeach
                </nav>
            </div>
        </div>
    </div>

    <div class="py-4 prose dark:prose-light">
        {{ $event->description }}
    </div>
</div>
