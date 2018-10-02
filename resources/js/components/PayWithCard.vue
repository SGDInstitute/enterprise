<template>
    <a href="#" class="list-group-item list-group-item-primary" @click.prevent="pay">
        <i class="fal fa-credit-card fa-fw ml-2" aria-hidden="true"></i> Pay with Card
    </a>
</template>

<script>
    export default {
        props: ['order', 'stripe_key'],
        data() {
            return {
                form: new SparkForm({
                    amount: 0,
                    email: '',
                    name: '',
                    stripeToken: '',
                }),
            }
        },
        created() {
            this.form.amount = this.order.amount;
            this.form.name = this.order.user.name;
            this.form.email = this.order.user.email;
            this.configure();
        },
        methods: {
            configure() {
                this.stripe = StripeCheckout.configure({
                    key: this.stripe_key,
                    image: "/img/sgdsocial.png",
                    locale: "auto",
                    zipCode: true,
                    billingAddress: true,
                    token: (token) => {
                        this.form.stripeToken = token.id;
                        this.form.stripeEmail = token.email;

                        Spark.post('/orders/' + this.order.id + '/charge', this.form)
                            .then(response => {
                                location.reload();
                            })
                            .catch(response => {
                                alert(response.message);
                            })
                    }
                });
            },
            pay() {
                this.stripe.open({
                    name: 'Pay for Order',
                    zipCode: true,
                    email: this.form.email,
                    amount: this.form.amount,
                    allowRememberMe: false
                });
            }
        }
    }
</script>