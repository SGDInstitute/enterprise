<div {{ $attributes->merge(['class' => 'min-w-full overflow-hidden overflow-scroll align-middle rounded-lg shadow']) }}>
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
        <thead>
            <tr>
                {{ $head }}
            </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-700 dark:divide-gray-600">
            {{ $body }}
        </tbody>
    </table>
</div>
