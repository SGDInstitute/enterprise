@props([
'label' => null
])

<div x-data="{on: @entangle($attributes->wire('model')) }" class="flex items-center">
    <!-- On: "bg-indigo-600", Off: "bg-gray-200" -->
    <button type="button" aria-labelledby="toggleLabel" @click="on = !on" :aria-pressed="on" :class="{'bg-blue-600 dark:bg-blue-700': on, 'bg-gray-200 dark:bg-gray-800': !on }" class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out bg-gray-200 border-2 border-transparent rounded-full cursor-pointer dark:bg-gray-800 w-11 focus:outline-none focus:shadow-outline">
        <span class="sr-only">Use setting</span>
        <!-- On: "translate-x-5", Off: "translate-x-0" -->
        <span aria-hidden="true" :class="{'translate-x-5': on, 'translate-x-0': !on }" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow dark:bg-gray-400">
        </span>
    </button>
    @if($label)
    <span class="ml-3" id="toggleLabel">
        <span class="text-sm text-gray-900 glacial dark:text-gray-200">{{ $label }}</span>
    </span>
    @endif
</div>
