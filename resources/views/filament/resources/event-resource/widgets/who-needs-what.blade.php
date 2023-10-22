<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">Who Needs What</x-slot>
        <div class="flex gap-x-3 items-center pb-4">
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="question">
                    <option value="">Select Question</option>
                    @foreach($questions as $question)
                    <option value="{{ $question['id'] }}">{{ $question['question'] }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>

            @if ($options !== [])
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="option">
                    <option value="">Select Option</option>
                    @foreach($options as $option)
                    <option>{{ $option }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
            @endif

            <x-filament::button wire:click="run">Run</x-filament::button>
        </div>
        <div class="fi-section-content-ctn border-t pt-4 border-gray-200 dark:border-white/10">
            <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                    @foreach ($report as $item)
                    <tr>
                        <td>{{ $item->user->name }} <small>({{ $item->user->pronouns }})</small></td>
                        <td>{{ $item->user->email }}</td>
                        <td>{{ $item->id }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
