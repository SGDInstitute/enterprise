<template>
    <div>
        <div class="media-card" v-for="type in ticket_types">
            <div class="media-card__content">
                <h2 class="media-card__title">{{ type.formatted_cost }}
                    <div v-if="type.is_open" class="pull-right col-md-6 pr-0">
                        <label for="ticket_quantity" class="sr-only">Ticket Quantity</label>
                        <input type="number" id="ticket_quantity" class="form-control" v-model="tickets[type.id]" placeholder="Quantity">
                    </div>
                    <small class="pull-right" v-else data-toggle="tooltip" data-placement="top" :title="'Opens on ' + formatDate(type.availability_start)">Closed</small>
                </h2>
                <p>{{ type.name }}</p>
                <p v-show="type.description" class="text-muted">{{ type.description }}</p>
            </div>
        </div>
        <div class="media-card">
            <div class="media-card__content">
                <h2 class="media-card__title">Subtotal
                    <small class="pull-right">${{ total }}</small>
                </h2>
                <button type="button" class="btn btn-primary btn-block">Save Order</button>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props: ['ticket_types'],
        data() {
            return {
                tickets: []
            }
        },
        methods: {
            formatDate(date) {
                return moment().format('MM/DD/YY');
            }
        },
        computed: {
            total() {
                let total = 0;
                let self = this;
                this.tickets.forEach(function(quantity, type) {
                    total += self.ticket_types.find(x => x.id === parseInt(type)).cost * quantity;
                });
                return (total/100).toFixed(2);
            }
        }
    }
</script>