<div
    {{ $attributes->merge(['class' => 'min-w-full overflow-hidden overflow-scroll align-middle rounded-lg shadow']) }}
>
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        @isset($head)
            <thead>
                <tr>
                    {{ $head }}
                </tr>
            </thead>
        @endif

        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
            {{ $body }}
        </tbody>
    </table>
</div>
