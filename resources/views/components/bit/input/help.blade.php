<div {{ $attributes->merge(['class' => 'mb-1 text-sm text-gray-500 dark:text-gray-400 prose-p:m-0']) }}>
    {!! markdown($slot) !!}
</div>
