@props([
    'label' => null,
])

<div x-data="{ on: @entangle($attributes->wire('model')).live }" class="flex items-center">
    <!-- On: "bg-indigo-600", Off: "bg-gray-200" -->
    <button
        type="button"
        aria-labelledby="toggleLabel"
        @click="on = !on"
        :aria-pressed="on"
        :class="{'bg-blue-600 dark:bg-blue-700': on, 'bg-gray-200 dark:bg-gray-800': !on }"
        class="focus:shadow-outline relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-gray-200 transition-colors duration-200 ease-in-out focus:outline-none dark:bg-gray-800"
    >
        <span class="sr-only">Use setting</span>
        <!-- On: "translate-x-5", Off: "translate-x-0" -->
        <span
            aria-hidden="true"
            :class="{'translate-x-5': on, 'translate-x-0': !on }"
            class="inline-block h-5 w-5 translate-x-0 transform rounded-full bg-white shadow transition duration-200 ease-in-out dark:bg-gray-400"
        ></span>
    </button>
    @if ($label)
        <span class="ml-3" id="toggleLabel">
            <span class="text-sm text-gray-900 dark:text-gray-200">{{ $label }}</span>
        </span>
    @endif
</div>
