<div class="container px-12 py-12 mx-auto prose dark:prose-light">
    <h1>{{ $form->name }}</h1>
    <p>This form can be saved an returned to later.</p>

    <div class="space-y-4">
        @foreach($form->form as $item)
            @if($item['style'] === 'content')
                {!! $item['content'] !!}
            @elseif ($item['style'] === 'question')
                @if($item['type'] === 'textarea')
                <x-bit.input.group :for="$item['id']" :label="$item['question']">
                    <x-bit.input.textarea class="w-full mt-1" :id="$item['id']" wire:model="response.{{ $item['id'] }}" />
                </x-bit.input.group>
                @elseif($item['type'] === 'text')
                <x-bit.input.group :for="$item['id']" :label="$item['question']">
                    <x-bit.input.text type="text" class="w-full mt-1" :id="$item['id']" wire:model="response.{{ $item['id'] }}" />
                </x-bit.input.group>
                @elseif($item['type'] === 'list' && $item['list-style'] === 'dropdown')
                <x-bit.input.group :for="$item['id']" :label="$item['question']">
                    <x-bit.input.select class="w-full mt-1" :id="$item['id']" wire:model="response.{{ $item['id'] }}">
                        @foreach($item['options'] as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                        @if($item['list-other'] === true)
                        <option value="other">Other</option>
                        @endif
                    </x-bit.input.select>
                </x-bit.input.group>
                @elseif($item['type'] === 'list' && $item['list-style'] === 'checkbox')
                <x-bit.input.group :for="$item['id']" :label="$item['question']">
                    <div class="mt-1 space-y-1">
                        @foreach($item['options'] as $option)
                            <x-bit.input.checkbox :value="$option" :label="$option" />
                        @endforeach
                        @if(isset($item['list-other']) && $item['list-other'] === true)
                            <x-bit.input.checkbox value="other" label="Other" />
                        @endif
                    </div>
                </x-bit.input.group>
                @elseif($item['type'] === 'list' && $item['list-style'] === 'radio')
                <x-bit.input.group :for="$item['id']" :label="$item['question']">
                    <div class="mt-1 space-y-1">
                        @foreach($item['options'] as $option)
                            <x-bit.input.radio :value="$option" :label="$option" />
                        @endforeach
                        @if(isset($item['list-other']) && $item['list-other'] === true)
                            <x-bit.input.radio value="other" label="Other" />
                        @endif
                    </div>
                </x-bit.input.group>
                @else
                    @json($item)
                @endif
            @elseif ($item['style'] === 'collaborators')
                <div>
                    <strong>Collaborators:</strong>
                    <x-bit.input.group :for="$item['id']" label="Add the emails of those who will be presenting with you (if any)">
                        <x-bit.input.textarea class="w-full mt-1" :id="$item['id']" wire:model="response.{{ $item['id'] }}" />
                        <x-bit.input.help>They will be added as a collaborator and will be allowed to make changes to this submission.</x-bit.input.help>
                    </x-bit.input.group>
                </div>
            @else
            @json($item)
            @endif
        @endforeach
    </div>
</div>
