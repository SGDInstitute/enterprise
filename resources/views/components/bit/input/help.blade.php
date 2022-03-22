<div {{ $attributes->merge(['class' => 'mt-2 text-sm text-gray-500 dark:text-gray-400']) }}>
    {!! markdown($slot) !!}
</div>
