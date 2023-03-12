<nav aria-label="Progress">
    <ol class="border border-gray-300 divide-y divide-gray-300 rounded-md dark:bg-gray-700 dark:divide-gray-500 dark:border-gray-500 md:flex md:divide-y-0">
        @foreach ($steps as $index => $step)
        <li class="relative md:flex-1 md:flex">
            <div class="flex items-center w-full">
                <span class="flex items-center justify-between w-full px-6 py-4 text-sm font-medium">
                    <div class="flex items-center">
                        @if ($step['complete'])
                        <span class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-green-500 rounded-full">
                            <x-heroicon-s-check class="w-6 h-6 text-white" />
                        </span>
                        @elseif ($step['name'] === $current['name'])
                        <span class="flex items-center justify-center flex-shrink-0 w-10 h-10 border-2 border-green-500 rounded-full">
                            <span class="text-green-500 dark:text-green-400">0{{ $index + 1 }}</span>
                        </span>
                        @else
                        <span class="flex items-center justify-center flex-shrink-0 w-10 h-10 border-2 border-gray-300 rounded-full dark:border-gray-400">
                            <span class="text-gray-500 dark:text-gray-400">0{{ $index + 1 }}</span>
                        </span>
                        @endif

                        @if (isset($step['link']) && $step['available'] === true && $step['complete'] !== true)
                        <a href="{{ $step['link'] }}" class="ml-4 text-lg font-medium text-green-500 animate-pulse dark:text-green-400">{{ $step['name'] }}</a>
                        @else
                        <span class="ml-4 text-sm font-medium text-gray-900 dark:text-gray-200">{{ $step['name'] }}</span>
                        @endif
                    </div>
                    @isset($step['help'])
                        <x-dynamic-component :component="$step['help']" />
                    @endif
                </span>
            </div>

            @if (!$loop->last)
            <div class="absolute top-0 right-0 hidden w-5 h-full md:block" aria-hidden="true">
                <svg class="w-full h-full text-gray-300 dark:text-gray-500" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                    <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
                </svg>
            </div>
            @endif
        </li>
        @endforeach
    </ol>
</nav>
