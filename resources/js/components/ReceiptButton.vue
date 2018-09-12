<template>
    <a href="#" class="list-group-item list-group-item-action" @click.prevent="show">
        <i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> View Receipt
    </a>
</template>

<script>
    export default {
        props: ['order'],
        methods: {
            show() {
                this.eventHub.$emit('showViewReceipt');
            }
        }
    }
</script>