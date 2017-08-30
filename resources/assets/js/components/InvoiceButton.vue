<template>
    <a href="#" class="list-group-item list-group-item-action" @click.prevent="show">
        <i class="fa fa-fw" :class="this.icon" aria-hidden="true"></i> {{ action }} Invoice
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
                    this.eventHub.$emit('showCreateInvoice');
                }
                else {
                    this.eventHub.$emit('showViewInvoice');
                }
            }
        }
    }
</script>