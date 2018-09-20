<template>
    <button type="button" @click.prevent="update">
        <slot>Update Card</slot>
    </button>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    email: '',
                    stripeToken: '',
                }
            }
        },
        created() {
            let self = this;
            this.stripe = StripeCheckout.configure({
                key: SGDInstitute.instituteStripe,
                locale: "auto",
                email: SGDInstitute.user.email,
                token: function(token) {
                    self.form.payment_token = token.id;
                    self.form.email = token.email;

                    self.$toasted.show("Updating your credit card information, the page should reload shortly.", {
                        duration: 5000,
                        type: "info"
                    });

                    axios.post('/api/me/card', self.form)
                        .then(response => {
                            window.location.reload();
                        });
                }
            });
        },
        methods: {
            update() {
                this.stripe.open({
                    image: "/img/sgdsocial.png",
                    name: 'SGD Institute',
                    panelLabel: "Update Card Details",
                    allowRememberMe: false,
                    zipCode: true,
                    // billingAddress: true,
                });
            }
        }
    }
</script>
