<x-bit.input.group :for="$item['id']" :label="$item['question']" :error="$errors->first('answers.' . $item['id'])">
    @isset($item['help'])
        <x-bit.input.help>{{ $item['help'] }}</x-bit.input.help>
    @endif

    <fieldset class="mt-2">
        <legend class="sr-only">Choose an option</legend>
        <div class="flex gap-3 items-center justify-between">
            @foreach (range(1, $item['range']) as $option)
            <label @class([
                    'flex items-center justify-center rounded-md py-3 px-3 text-sm font-semibold uppercase sm:flex-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2',
                    'bg-green-600 text-white hover:bg-green-500' => $answers[$item['id']] == $option,
                    'ring-1 ring-inset ring-gray-300 dark:ring-gray-700 bg-white dark:bg-transparent text-gray-900 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-850' => $answers[$item['id']] != $option,
                    'opacity-25 cursor-not-allowed' => !$fillable
                ])
            >
                <input type="radio" :name="$item['id']" wire:model.live="answers.{{ $item['id'] }}" class="sr-only" value="{{ $option }}" aria-labelledby="opinion-scale-{{ $item['id'] }}-{{ $option }}-label" :disabled="!$fillable">
                <span id="opinion-scale-{{ $item['id'] }}-{{ $option }}-label">{{ $option }}</span>
            </label>
            @endforeach
        </div>
        <div class="text-gray-700 dark:text-gray-400 flex gap-3 mt-2 items-center justify-between">
            <span>{{ $item['low_label'] }}</span>
            <span>{{ $item['high_label'] }}</span>
        </div>
    </fieldset>
</x-bit.input.group>
