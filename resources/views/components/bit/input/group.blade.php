@props([
    'label',
    'for',
    'error' => false,
    'helpText' => false,
    'inline' => false,
    'paddingless' => false,
    'borderless' => false,
    'srOnly' => false
])

@if(!$inline)
<div {{ $attributes }}>
    @isset($label)
    @isset($for)
    <label for="{{ $for }}" class="{{ $srOnly ? 'sr-only' : 'block font-medium mb-1 leading-5 text-gray-700 dark:text-gray-200' }}">{{ $label }}</label>
    @else
    <span class="{{ $srOnly ? 'sr-only' : 'block font-medium leading-5 mb-1 text-gray-700 dark:text-gray-200' }}">{{ $label }}</span>
    @endif
    @endif
    {{ $slot }}

    @if ($error)
    <div class="mt-1 text-red-500">{{ $error }}</div>
    @endif

    @if ($helpText)
    <p class="mt-2 text-gray-500">{{ $helpText }}</p>
    @endif
</div>
@else
<div {{ $attributes->merge(['class' => 'flex space-x-4 sm:items-center sm:border-gray-200' . ($borderless ? '' : ' sm:border-t ') . ($paddingless ? '' : ' sm:py-5') ]) }}">
    @isset($label)
    <label for="{{ $for }}" class="block font-medium leading-5 mb-1 text-gray-700 dark:text-gray-200 {{ $paddingless ? '' : 'sm:mt-px sm:pt-2' }}">
        {{ $label }}
    </label>
    @endif

    <div class="mt-1 sm:mt-0 sm:col-span-2">
        {{ $slot }}

        @if ($error)
        <div class="mt-1 text-red-500">{{ $error }}</div>
        @endif

        @if ($helpText)
        <p class="mt-2 text-gray-500">{{ $helpText }}</p>
        @endif
    </div>
</div>
@endif
