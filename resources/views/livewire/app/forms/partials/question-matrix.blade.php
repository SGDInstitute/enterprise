@php
    $options = [];
    $scales = [];

    foreach($item['options'] as $option) {
        if(str_contains($option, ':')) {
            $parts = explode(':', $option);
            $parts[0] = Str::slug($parts[0]);
            $options[$parts[0]] = $parts[1];
        } else {
            $options[$option] = $option;
        }
    }

    foreach($item['scale'] as $scale) {
        if(str_contains($scale, ':')) {
            $parts = explode(':', $scale);
            $parts[0] = Str::slug($parts[0]);
            $scales[$parts[0]] = $parts[1];
        } else {
            $scales[$scale] = $scale;
        }
    }
@endphp

<div>
    <x-bit.input.group :for="$item['id']" :label="$item['question']" :error="$errors->first('answers.' . $item['id'])">
        @isset($item['help'])
            <x-bit.input.help>{{ $item['help'] }}</x-bit.input.help>
        @endif

        <table class="mt-0">
            <thead>
                <tr>
                    <th></th>
                    @foreach ($scales as $scale)
                    <th class="text-gray-900 dark:text-gray-200">{{ $scale }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($options as $option)
                <tr>
                    <td>{{ $option }}</td>
                    @foreach ($scales as $scale)
                    <td class="text-center align-middle-impt">
                        <x-bit.input.radio
                            class="flex items-center justify-center"
                            :value="$scale"
                            :id="$item['id'].'-'.$option.'-'.$scale"
                            wire:model.live="answers.{{ $item['id'] }}.{{ $option }}"
                            :disabled="!$fillable"
                        />
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </x-bit.input.group>

</div>
