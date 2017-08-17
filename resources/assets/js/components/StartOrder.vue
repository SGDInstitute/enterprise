<template>
    <form @submit.prevent="submit">
        <div class="media-card" v-for="(type, index) in ticket_types">
            <div class="media-card__content">
                <h2 class="media-card__title">{{ type.formatted_cost }}
                    <span v-if="type.is_open" class="pull-right col-md-6 pr-0">
                        <label for="ticket_quantity" class="sr-only">Ticket Quantity</label>
                        <input type="number" id="ticket_quantity" class="form-control"
                               v-model="form.tickets[index].quantity"
                               placeholder="Quantity">
                    </span>
                    <small class="pull-right" v-else data-toggle="tooltip" data-placement="top"
                           :title="'Opens on ' + formatDate(type.availability_start)">Closed
                    </small>
                </h2>
                <p>{{ type.name }}</p>
                <p v-show="type.description" class="text-muted">{{ type.description }}</p>
            </div>
        </div>
        <div class="media-card">
            <div class="media-card__content">
                <h4 class="ticket-price ticket-child">Promotional Code</h4>
                <span class="ticket-name ticket-child">If you have a promotional code, enter it below.</span>

                <label for="promo" class="sr-only">Promotional Code</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="promo" placeholder="Add promo code here...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Apply</button>
                    </span>
                </div><!-- /input-group -->
            </div>
        </div>
        <div class="media-card">
            <div class="media-card__content">
                <h2 class="media-card__title">Subtotal
                    <small class="pull-right">${{ total }}</small>
                </h2>
                <div class="alert alert-danger" role="alert" v-show="form.errors.has('tickets')">
                    {{ form.errors.get('tickets') }}
                </div>
                <button type="submit" class="btn btn-primary btn-block" :disabled="form.busy">Save Order</button>
            </div>
        </div>
    </form>
</template>

<script>
    import moment from 'moment';

    export default {
        props: ['ticket_types', 'event', 'user'],
        data() {
            return {
                form: new SparkForm({
                    tickets: [],
                    user: []
                }),
            }
        },
        created() {
            let self = this;
            this.ticket_types.forEach(function (item) {
                self.form.tickets.push({quantity: 0, ticket_type_id: item.id});
            });
            this.form.user = this.user;

            this.eventHub.$on('updatedUser', function(user) {
                self.form.user = user;
                self.submit();
            })
        },
        methods: {
            formatDate(date) {
                return moment(date).format('M/D/YY');
            },
            submit() {
                if(this.form.user === null) {
                    this.eventHub.$emit('showLoginRegister');
                }
                else {
                    Spark.post('/events/' + this.event.slug + '/orders', this.form)
                        .then(response => {
                            location.href = '/orders/' + response.order.id;
                        })
                        .catch(response => {
                        })
                }
            }
        },
        computed: {
            total() {
                let total = 0;
                let self = this;
                this.form.tickets.forEach(function (ticket) {
                    total += self.ticket_types.find(x => x.id === parseInt(ticket.ticket_type_id)).cost * ticket.quantity;
                });
                return (total / 100).toFixed(2);
            }
        }
    }
</script>