<template>
    <a href="#" class="list-group-item list-group-item-action" @click.prevent="pay">
        <i class="fa fa-money fa-fw" aria-hidden="true"></i> Pay with Check
    </a>
</template>

<script>
    export default {
        props: ['order'],
        methods: {
            pay() {
                if (typeof this.order.invoice === 'undefined') {
                    this.eventHub.$emit('showCreateInvoice', this.order.id);
                }
            }
        }
    }
</script>