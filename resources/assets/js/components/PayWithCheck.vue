<template>
    <a href="#" class="list-group-item list-group-item-primary" @click.prevent="show">
        <i class="fa fa-usd fa-fw ml-4" aria-hidden="true"></i> Pay with Check
    </a>
</template>

<script>
    export default {
        props: ['order'],
        methods: {
            show() {
                if (this.order.invoice === null) {
                    this.eventHub.$emit('showCreateInvoice');
                }
                else {
                    this.eventHub.$emit('showViewInvoice');
                }
            }
        }
    }
</script>