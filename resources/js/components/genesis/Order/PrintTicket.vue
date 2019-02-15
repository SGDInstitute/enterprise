<template>
    <div>
        <button @click.prevent="print" :disabled="disable" class="btn btn-mint">Print</button>

        <modal :show="show" @close="show = false">
            <div slot="body" class="px-6 py-8 bg-white">
                <p class="leading-normal mb-2">Awesome! Your {{ label }} been added to the queue and will be printed shortly.</p>

                <button class="btn btn-mint" @click.prevent="show = false">Print more Tickets</button>
                <router-link to="/" class="btn btn-link">Start Over</router-link>
            </div>
        </modal>
    </div>
</template>

<script>
    import Modal from './modal';

    export default {
        props: ['order', 'tickets', 'disable'],
        data() {
            return {
                show: false
            }
        },
        methods: {
            print() {
                let ids = _.map(this.tickets, function (ticket) {
                    return ticket.id;
                }).join();

                this.$http.post('/api/queue/' + ids)
                    .then(response => {
                        this.show = true;
                    });
            }
        },
        computed: {
            label() {
                return this.tickets.length > 1 ? this.tickets.length + ' name badges have' : 'name badge has';
            }
        },
        components: {Modal}
    }
</script>
