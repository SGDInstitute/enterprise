@props([
    'options' => [],
    'placeholder' => false,
])

<div
    wire:ignore
    x-data="{
        multiple: true,
        value: @entangle($attributes->get('wire:model.live')).live,
        options: {{ json_encode($options) }},
        init() {
            this.$nextTick(() => {
                let choices = new Choices(this.$refs.select, {
                    items: this.value,
                })

                this.$refs.select.addEventListener('change', () => {
                    this.value = choices.getValue(true)
                })
            })
        },
    }"
    class="mt-1 w-full"
>
    <input x-ref="select" :multiple="multiple" />
</div>
