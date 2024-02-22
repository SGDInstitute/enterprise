@props(['placement' => 'left', 'title' => 'Button'])

@php
    $placement = $placement === 'left' ? 'left-0' : 'right-0';
@endphp

<div class="flex justify-center">
    <div
        x-data="{
            open: false,
            toggle() {
                if (this.open) {
                    return this.close()
                }

                this.open = true
            },
            close(focusAfter) {
                if (! this.open) return

                this.open = false

                focusAfter && focusAfter.focus()
            },
        }"
        x-on:keydown.escape.prevent.stop="close($refs.button)"
        x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
        x-id="['dropdown-button']"
        class="relative"
    >
        <!-- Button -->
        <button
            x-ref="button"
            x-on:click="toggle()"
            :aria-expanded="open"
            :aria-controls="$id('dropdown-button')"
            type="button"
            class="btn btn-gray btn-base"
        >
            <span>{{ $title }}</span>
            <span aria-hidden="true" class="ml-1">&darr;</span>
        </button>

        <!-- Panel -->
        <div
            x-ref="panel"
            x-show="open"
            x-transition.origin.top.left
            x-on:click.outside="close($refs.button)"
            :id="$id('dropdown-button')"
            style="display: none"
            class="{{ $placement }} absolute mt-2 w-48 overflow-hidden rounded border border-black bg-white shadow-md"
        >
            {{ $slot }}
        </div>
    </div>
</div>
