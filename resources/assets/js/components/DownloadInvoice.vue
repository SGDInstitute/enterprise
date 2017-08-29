<template>
    <a href="#" class="list-group-item list-group-item-action" @click.prevent="download">
        <i class="fa fa-arrow-circle-down fa-fw" aria-hidden="true"></i> {{ action }} Invoice
    </a>
</template>

<script>
    export default {
        props: ['order'],
        data() {
            return {
                action: 'Create'
            }
        },
        created() {
            this.action = (this.order.invoice === null) ? 'Create' : 'Download';
        },
        methods: {
            download() {
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