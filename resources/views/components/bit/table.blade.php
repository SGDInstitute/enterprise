<div {{ $attributes->merge(['class' => 'min-w-full overflow-hidden overflow-scroll align-middle rounded-lg shadow']) }}>
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        @isset ($head)
        <thead>
            <tr>
                {{ $head }}
            </tr>
        </thead>
        @endif

        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
            {{ $body }}
        </tbody>
    </table>
</div>
