<template>
    <a href="#" class="list-group-item list-group-item-action" @click.prevent="download">
        <i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> {{ action }} Invoice
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
            this.action = (typeof this.order.invoice === 'undefined') ? 'Create' : 'Download';
        },
        methods: {
            download() {
                if (typeof this.order.invoice === 'undefined') {
                    this.eventHub.$emit('showCreateInvoice', this.order.id);
                }
            }
        }
    }
</script>