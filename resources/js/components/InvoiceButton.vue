<template>
    <a href="#" class="list-group-item list-group-item-action" @click.prevent="show">
        <i class="fal fa-fw fa-plus-circle"></i> {{ action }} Invoice
    </a>
</template>

<script>
    export default {
        props: ['order'],
        data() {
            return {
                action: 'Create',
                icon: 'fa-plus-circle'
            }
        },
        created() {
            this.action = (this.order.invoice === null) ? 'Create' : 'Download';
            this.icon = (this.order.invoice === null) ? 'fa-plus-circle' : 'fa-arrow-circle-down';
        },
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