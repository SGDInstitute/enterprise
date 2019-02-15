<template>
    <div>
        <button @click.prevent="show = true" class="btn btn-mint">Pay with Check</button>

        <modal :show="show" @close="show = false; $emit('paid')">
            <form slot="body" class="px-6 py-8 bg-white">
                <p class="leading-normal mb-2">Your order total is ${{ order.amount/100 }}. Please make checks payable to the Midwest Institute for Sexuality and Gender Diversity.</p>
                <p class="leading-normal">On the memo line please write: Order {{ order.id }}</p>
            </form>
        </modal>
    </div>
</template>

<script>
    import Modal from './modal';

    export default {
        props: ['order'],
        data() {
            return {
                show: false
            }
        },
        methods: {
            close() {
                this.show = false;
                this.$emit('paid');
            }
        },
        components: {Modal}
    }
</script>
