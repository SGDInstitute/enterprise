<template>
    <a href="#" class="list-group-item list-group-item-primary" @click.prevent="show">
        <i class="fal fa-fw fa-usd-circle ml-2"></i> Pay with Check
    </a>
</template>

<script>
    export default {
        props: ['order'],
        methods: {
            show() {
                if (this.order.invoice === null) {
                    this.eventHub.$emit('showInvoiceForm', 'create');
                }
                else {
                    this.eventHub.$emit('showViewInvoice');
                }
            }
        }
    }
</script>