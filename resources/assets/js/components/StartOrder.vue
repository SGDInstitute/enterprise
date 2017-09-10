<template>
    <form @submit.prevent="submit">
        <div class="card" v-for="(type, index) in ticket_types">
            <div class="card-body">
                <h2 class="card-title">{{ type.formatted_cost }}
                    <span v-if="type.is_open" class="pull-right col-md-6 pr-0">
                        <label for="ticket_quantity" class="sr-only">Ticket Quantity</label>
                        <input type="number" id="ticket_quantity" class="form-control" min="0"
                               v-model="form.tickets[index].quantity"
                               placeholder="Quantity">
                    </span>
                    <small class="pull-right" v-else data-toggle="tooltip" data-placement="top"
                           :title="'Opens on ' + formatDate(type.availability_start)">Closed
                    </small>
                </h2>
                <p class="card-text">{{ type.name }}</p>
                <small v-if="type.description" class="card-text text-muted">{{ type.description }}</small>
            </div>
        </div>
        <!--<div class="card">-->
            <!--<div class="card-body">-->
                <!--<h4 class="card-title">Promotional Code</h4>-->
                <!--<small class="card-text text-muted">If you have a promo code, enter it below.</small>-->
                <!--<label for="promo" class="sr-only">Promotional Code</label>-->
                <!--<div class="input-group">-->
                    <!--<input type="text" class="form-control" id="promo">-->
                    <!--<span class="input-group-btn">-->
                        <!--<button class="btn btn-secondary" type="button">Apply</button>-->
                    <!--</span>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Subtotal
                    <small class="pull-right">${{ total }}</small>
                </h2>
                <div class="alert alert-danger" role="alert" v-show="form.errors.has('tickets')">
                    {{ form.errors.get('tickets') }}
                </div>
                <button type="submit" class="btn btn-primary btn-block" :disabled="form.busy">Next</button>
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