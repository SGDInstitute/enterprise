<template>
    <div class="flex -mx-4 h-full">
        <router-link to="/check-in" class="absolute pin-t p-2 text-grey-darker no-underline hover:text-grey-darkest"><
            Back
        </router-link>
        <div class="w-1/2 mx-auto">
            <div class="shadow bg-white p-8 h-full overflow-hidden">
                <h1 class="text-3xl font-normal mb-8 text-blue-darker">Order:
                    <small>{{ number }}</small>
                </h1>

                <div class="mb-4 overflow-y-scroll max-h-85">
                    <div v-for="ticket in order.tickets" :key="ticket.hash"
                         class="border rounded mb-1 flex justify-between">
                        <label class="text-lg p-4">
                            <input type="checkbox" class="mr-2" v-model="tickets" :value="ticket">
                            <span v-if="ticket.user_id" class="pt-px">
                                    {{ ticket.user.name }}
                                    <small class="italic">({{ ticket.user.profile.pronouns ? ticket.user.profile.pronouns : 'not listed' }})</small>
                                </span>
                            <span v-else class="pt-px italic">
                                    No user added to ticket
                                </span>
                        </label>
                        <div class="p-4">
                            <router-link :to="'/tickets/' + ticket.hash"
                                         class="no-underline p-2 rounded text-mint hover:bg-grey-lighter hover:text-mint-dark">
                                Edit
                            </router-link>
                        </div>
                    </div>
                </div>

                <div v-if="!isPaid && orderIsReady">
                    <pay-with-card :order="order"></pay-with-card>
                    <pay-with-check class="inline-block" :order="order"></pay-with-check>
                </div>
                <button v-else class="btn btn-mint" :disabled="cannotPrint" @click="print">Print</button>

                <div v-if="error">
                    <p class="text-lg">{{ error }}</p>
                    <router-link to="/check-in"
                    class="no-underline mt-4 inline-block text-center rounded bg-blue px-3 py-2 text-white font-semibold hover:bg-blue-dark">
                    Go Back
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PayWithCard from './Order/PayWithCard'
    import PayWithCheck from './Order/PayWithCheck'

    export default {
        name: 'order',
        props: ['number'],
        data() {
            return {
                order: {},
                tickets: [],
                error: ''
            }
        },
        created() {
            this.$http.get('/api/orders/' + this.number)
                .then(response => {
                    this.order = response.data;
                })
                .catch(error => {
                    if (error.response.status === 404) {
                        this.error = 'An order with that confirmation number was not found.';
                    } else {
                        this.error = 'Undefined issue, please ask for help.';
                    }
                });
        },
        methods: {
            print() {
                let ids = _.map(this.tickets, function (ticket) {
                    return ticket.id;
                }).join();
                this.$http.post('/api/queue/' + ids);
            }
        },
        computed: {
            cannotPrint() {
                return _.filter(this.tickets, function (ticket) {
                    return ticket.user_id;
                }).length === 0;
            },
            isPaid() {
                return !_.isEmpty(this.order.confirmation_number);
            },
            orderIsReady() {
                return !_.isEmpty(this.order);
            }
        },
        components: {PayWithCard, PayWithCheck}
    }
</script>
