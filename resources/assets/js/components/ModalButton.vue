<template>
    <a href="#" @click.prevent="show">
        <slot></slot>
    </a>
</template>

<script>
    export default {
        props: ['event', 'payload'],
        methods: {
            show() {
                this.eventHub.$emit(this.event, this.payload);
            }
        }
    }
</script>