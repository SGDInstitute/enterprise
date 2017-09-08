<template>
    <a href="#" @click.prevent="show">
        <slot></slot>
    </a>
</template>

<script>
    export default {
        props: ['event'],
        methods: {
            show() {
                this.eventHub.$emit(this.event);
            }
        }
    }
</script>