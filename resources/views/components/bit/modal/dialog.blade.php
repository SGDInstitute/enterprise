@props(['id' => null, 'maxWidth' => null])

<x-bit.modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg dark:text-gray-200">
            {{ $title }}
        </div>

        <div class="mt-4">
            {{ $content }}
        </div>
    </div>

    @isset ($footer)
    <div class="px-6 py-4 text-right bg-gray-100 rounded-b-lg dark:bg-gray-800 dark:border-t dark:border-gray-700">
    {{ $footer }}
    </div>
    @endisset
</x-modal>
