<div
    x-data
    x-init="
        easyMDE = new EasyMDE({element: $refs.textarea, forceSync: true, autoRefresh: true})
        easyMDE.codemirror.on('change', function(){
            @this.set('{{ $attributes['wire:model.live'] }}', easyMDE.value());
        });
    "
    wire:ignore
    class="mt-1"
>
    <textarea x-ref="textarea" {{ $attributes }}></textarea>
</div>
