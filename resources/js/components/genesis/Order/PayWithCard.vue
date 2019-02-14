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
                        let self = this;

                        this.$http.post('/api/orders/' + this.order.id + '/charge', this.form)
                            .then(response => {
                                self.$toasted.success('Successfully paid for this order! Now you can start printing your name badges.');
                            })
                            .catch(error => {
                                console.log(error);
                                alert(error.message);
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
