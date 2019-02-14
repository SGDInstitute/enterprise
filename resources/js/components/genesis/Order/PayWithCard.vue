<template>
    <button class="btn btn-mint" @click.prevent="pay">Pay with Card</button>
</template>

<script>
    export default {
        props: ['order'],
        data() {
            return {
                form: {
                    amount: 0,
                    email: '',
                    name: '',
                    stripeToken: '',
                },
            }
        },
        created() {
            this.form.amount = this.order.amount;
            this.configure();
        },
        methods: {
            configure() {
                this.stripe = StripeCheckout.configure({
                    key: SGDInstitute.mblgtaccStripe,
                    image: "/img/sgdsocial.png",
                    locale: "auto",
                    zipCode: true,
                    billingAddress: true,
                    token: (token) => {
                        this.form.stripeToken = token.id;
                        this.form.stripeEmail = token.email;

                        this.$http.post('/orders/' + this.order.id + '/charge', this.form)
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
                    amount: this.form.amount,
                    allowRememberMe: false
                });
            }
        }
    }
</script>
