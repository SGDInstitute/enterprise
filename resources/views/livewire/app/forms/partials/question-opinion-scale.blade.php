<x-bit.input.group :for="$item['id']" :label="$item['question']" :error="$errors->first('answers.' . $item['id'])">
    @isset($item['help'])
        <x-bit.input.help>{{ $item['help'] }}</x-bit.input.help>
    @endif

    <fieldset class="mt-2">
        <legend class="sr-only">Choose an option</legend>
        <div class="flex items-center justify-between gap-3">
            @foreach (range(1, $item['range']) as $option)
                <label
                    @class([
                        'flex cursor-pointer items-center justify-center rounded-md px-3 py-3 text-sm font-semibold uppercase focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 sm:flex-1',
                        'bg-green-600 text-white hover:bg-green-500' => $answers[$item['id']] == $option,
                        'bg-white text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-transparent dark:text-gray-200 dark:ring-gray-700 dark:hover:bg-gray-850' =>
                            $answers[$item['id']] != $option,
                        'cursor-not-allowed opacity-25' => ! $fillable,
                    ])
                >
                    <input
                        type="radio"
                        :name="$item['id']"
                        wire:model.live="answers.{{ $item['id'] }}"
                        class="sr-only"
                        value="{{ $option }}"
                        aria-labelledby="opinion-scale-{{ $item['id'] }}-{{ $option }}-label"
                        :disabled="!$fillable"
                    />
                    <span id="opinion-scale-{{ $item['id'] }}-{{ $option }}-label">{{ $option }}</span>
                </label>
            @endforeach
        </div>
        <div class="mt-2 flex items-center justify-between gap-3 text-gray-700 dark:text-gray-400">
            <span>{{ $item['low_label'] }}</span>
            <span>{{ $item['high_label'] }}</span>
        </div>
    </fieldset>
</x-bit.input.group>
