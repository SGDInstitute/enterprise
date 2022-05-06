<div class="lg:border-t lg:border-b lg:border-gray-200 dark:lg:border-gray-700 bg-gray-50 dark:bg-gray-850">
    <nav class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8" aria-label="Progress">
        <ol role="list" class="overflow-hidden rounded-md lg:flex lg:border-l lg:border-r lg:border-gray-200 dark:lg:border-gray-700 lg:rounded-none">
            @foreach ($steps as $step)
            <li class="relative overflow-hidden lg:flex-1">
                @isset ($step['route'])
                <a href="{{ $step['route'] }}" class="w-full overflow-hidden border border-t-0 border-gray-200 group dark:border-gray-700 rounded-b-md lg:border-0">
                    @if ($step['current'])
                    <span class="absolute top-0 left-0 w-1 h-full bg-green-600 dark:bg-green-400 lg:w-full lg:h-1 lg:bottom-0 lg:top-auto" aria-hidden="true"></span>
                    @else
                    <span class="absolute top-0 left-0 w-1 h-full bg-transparent group-hover:bg-gray-200 dark:group-hover:bg-gray-700 lg:w-full lg:h-1 lg:bottom-0 lg:top-auto" aria-hidden="true"></span>
                    @endif
                    <span class="flex items-center px-6 py-5 text-sm font-medium lg:pl-9">
                        <span class="flex-shrink-0">
                            @if ($step['complete'])
                            <span class="flex items-center justify-center w-10 h-10 bg-green-600 rounded-full dark:bg-green-400">
                                <x-heroicon-s-check class="w-6 h-6 text-white" />
                            </span>
                            @elseif ($step['current'])
                            <span class="flex items-center justify-center w-10 h-10 border-2 border-green-600 rounded-full dark:border-green-400">
                                <span class="text-green-600 dark:text-green-400">0{{ $loop->iteration }}</span>
                            </span>
                            @else
                            <span class="flex items-center justify-center w-10 h-10 border-2 border-gray-300 rounded-full dark:border-gray-700">
                                <span class="text-gray-500 dark:text-gray-400">0{{ $loop->iteration }}</span>
                            </span>
                            @endif
                        </span>
                        <span class="mt-0.5 ml-4 min-w-0 flex flex-col">
                            @if ($step['current'])
                            <span class="text-xs font-semibold tracking-wide text-gray-900 uppercase dark:text-gray-200">{{ $step['title'] }}</span>
                            @else
                            <span class="text-xs font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400">{{ $step['title'] }}</span>
                            @endif
                            @isset ($step['subtitle'])
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $step['subtitle'] }}</span>
                            @endif
                        </span>
                    </span>

                    @if (!$loop->first)
                    <div class="absolute inset-0 top-0 left-0 hidden w-3 lg:block" aria-hidden="true">
                        <svg class="w-full h-full text-gray-300 dark:text-gray-700" viewBox="0 0 12 82" fill="none" preserveAspectRatio="none">
                            <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor" vector-effect="non-scaling-stroke" />
                        </svg>
                    </div>
                    @endif
                </a>
                @else
                <button type="button" disabled class="w-full overflow-hidden border border-t-0 border-gray-200 disabled:opacity-75 disabled:cursor-not-allowed group dark:border-gray-700 rounded-b-md lg:border-0">
                    @if ($step['current'])
                    <span class="absolute top-0 left-0 w-1 h-full bg-green-600 dark:bg-green-400 lg:w-full lg:h-1 lg:bottom-0 lg:top-auto" aria-hidden="true"></span>
                    @else
                    <span class="absolute top-0 left-0 w-1 h-full bg-transparent group-hover:bg-gray-200 dark:group-hover:bg-gray-700 lg:w-full lg:h-1 lg:bottom-0 lg:top-auto" aria-hidden="true"></span>
                    @endif
                    <span class="flex items-center px-6 py-5 text-sm font-medium lg:pl-9">
                        <span class="flex-shrink-0">
                            @if ($step['complete'])
                            <span class="flex items-center justify-center w-10 h-10 bg-green-600 rounded-full dark:bg-green-400">
                                <x-heroicon-s-check class="w-6 h-6 text-white" />
                            </span>
                            @elseif ($step['current'])
                            <span class="flex items-center justify-center w-10 h-10 border-2 border-green-600 rounded-full dark:border-green-400">
                                <span class="text-green-600 dark:text-green-400">0{{ $loop->iteration }}</span>
                            </span>
                            @else
                            <span class="flex items-center justify-center w-10 h-10 border-2 border-gray-300 rounded-full dark:border-gray-700">
                                <span class="text-gray-500 dark:text-gray-400">0{{ $loop->iteration }}</span>
                            </span>
                            @endif
                        </span>
                        <span class="mt-0.5 ml-4 min-w-0 flex flex-col">
                            @if ($step['current'])
                            <span class="text-xs font-semibold tracking-wide text-gray-900 uppercase dark:text-gray-200">{{ $step['title'] }}</span>
                            @else
                            <span class="text-xs font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400">{{ $step['title'] }}</span>
                            @endif
                            @isset ($step['subtitle'])
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $step['subtitle'] }}</span>
                            @endif
                        </span>
                    </span>

                    @if (!$loop->first)
                    <div class="absolute inset-0 top-0 left-0 hidden w-3 lg:block" aria-hidden="true">
                        <svg class="w-full h-full text-gray-300 dark:text-gray-700" viewBox="0 0 12 82" fill="none" preserveAspectRatio="none">
                            <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor" vector-effect="non-scaling-stroke" />
                        </svg>
                    </div>
                    @endif
                </button>
                @endif
            </li>
            @endforeach
        </ol>
    </nav>
</div>
