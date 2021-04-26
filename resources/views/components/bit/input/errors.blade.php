@if(!$errors->isEmpty())
<div {{ $attributes->merge(['class' => 'p-4 border border-red-500 rounded-md bg-red-50 dark:bg-red-700']) }}>
    <div class="flex">
        <div class="flex-shrink-0">
            <x-dynamic-component component="heroicon-o-x-circle" class="w-5 h-5 text-red-400" />
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium leading-5 text-red-700 dark:text-red-200">
                Validation Errors
            </h3>
            <div class="mt-2 text-sm leading-5 text-red-700 dark:text-red-200">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
