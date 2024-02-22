@props([
    'title',
    'icon',
    'button',
])

<div x-data="{ isOpen: false }">
    @isset($button)
        {{ $button }}
    @else
        @isset($icon)
            <button
                type="button"
                @click="isOpen = !isOpen"
                class="text-gray-500 transition duration-150 ease-in-out hover:text-blue-500 dark:text-gray-300 dark:hover:text-blue-400"
            >
                <x-dynamic-component :component="$icon" class="h-6 w-6" />
            </button>
        @else
            <button
                type="button"
                @click="isOpen = !isOpen"
                class="focus:shadow-outline-green absolute right-0 top-0 z-40 mr-8 transform rounded-b-md border border-green-600 bg-green-600 px-3 py-1 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out hover:bg-green-500 focus:border-green-300 focus:outline-none active:bg-green-700 dark:border-green-600 dark:bg-green-600 dark:hover:bg-green-700 dark:active:bg-green-700"
            >
                <x-heroicon-o-question-mark-circle class="h-6 w-6" />
            </button>
        @endif
    @endif
    <div x-cloak x-show="isOpen" class="fixed inset-0 z-50 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div
                x-show="isOpen"
                x-transition:enter="duration-500 ease-in-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="duration-500 ease-in-out"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                @click="isOpen = !isOpen"
            ></div>

            <section class="absolute inset-y-0 right-0 flex max-w-full pl-10">
                <div
                    x-show="isOpen"
                    x-transition:enter="transform transition duration-500 ease-in-out sm:duration-700"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition duration-500 ease-in-out sm:duration-700"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="w-screen max-w-md"
                >
                    <div
                        class="flex h-full flex-col space-y-6 overflow-y-scroll bg-white py-6 shadow-xl dark:bg-gray-700"
                    >
                        <header class="px-4 sm:px-6">
                            <div class="flex items-start justify-between space-x-3">
                                <h2 class="text-lg font-medium leading-7 text-gray-900 dark:text-gray-100">
                                    {{ $title }}
                                </h2>
                                <div class="flex h-7 items-center">
                                    <button
                                        @click="isOpen = !isOpen"
                                        aria-label="Close panel"
                                        class="text-gray-400 transition duration-150 ease-in-out hover:text-gray-500 dark:text-gray-200 dark:hover:text-gray-100"
                                    >
                                        <svg
                                            class="h-6 w-6"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </header>
                        <div class="prose relative flex-1 px-4 dark:prose-light sm:px-6">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
