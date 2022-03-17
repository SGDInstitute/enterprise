<div
    x-data="{
        open: false,
        toggle() {
            this.open = this.open ? this.close() : true
        },
        close() {
            this.open = false
        }
    }"
    x-on:keydown.escape.prevent.stop="close"
    class="relative"
>
    <button
        @click="toggle"
        type="button"
        :aria-expanded="open"
        :aria-controls=""
        @click.outside="close"
        class="px-4 py-2 border border-black focus:outline-none focus:ring-4 focus:ring-green-500"
    >
        <span>{{ $title }}</span>
        <span aria-hidden="true"></span>
    </button>

    <div x-show="open" style="display:none" class="absolute left-0 mt-2 bg-white border border-black">
        {{ $slot }}
    </div>
</div>
