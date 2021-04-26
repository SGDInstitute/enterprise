<div x-data
    x-init="
        easyMDE = new EasyMDE({element: $refs.textarea, forceSync: true})
        easyMDE.codemirror.on('change', function(){
            @this.set('{{ $attributes['wire:model'] }}', easyMDE.value());
        });
    "
    wire:ignore
>
    <textarea x-ref="textarea" {{ $attributes }}></textarea>
</div>
