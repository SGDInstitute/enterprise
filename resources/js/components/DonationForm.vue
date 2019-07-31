<template>
    <form>
        <div class="w-full">
            <label class="form-label" for="amount">
                Amount *
            </label>
            <div class="relative flex flex-wrap items-stretch w-full">
                <div class="flex">$</div>
                <input class="form-control" id="amount" type="text" placeholder="20">
                <div class="flex">.00</div>
            </div>
            <span class="help-block" v-show="form.errors.has('amount')">
                {{ form.errors.get('amount') }}
            </span>
        </div>

        <div class="form-group row" :class="{'has-error': form.errors.has('subscription')}">
            <label for="subscription" class="col-sm-4 control-label">Would you like to repeat this gift?*</label>
            <div class="col-sm-8">
                <select name="subscription" id="subscription" class="form-control" v-model="form.subscription">
                    <option value="no">No, this is one time only</option>
                    <option value="monthly">Yes, repeat this gift monthly</option>
                    <option value="quarterly">Yes, repeat this gift quarterly</option>
                    <option value="yearly">Yes, repeat this gift yearly</option>
                </select>
                <span class="help-block" v-show="form.errors.has('subscription')">
                    {{ form.errors.get('subscription') }}
                </span>
            </div>
        </div>

        <input type="hidden" name="group" value="institute">

        <div class="w-full">
            <label class="form-label" for="name">
                Your Name *
            </label>
            <input class="form-control" id="name" type="text" placeholder="Jax Doe">
            <span class="help-block" v-show="form.errors.has('name')">
                {{ form.errors.get('name') }}
            </span>
        </div>

        <div class="w-full">
            <label class="form-label" for="email">
                Your Email *
            </label>
            <input class="form-control" id="email" type="text" placeholder="jaxdoe@gmail.com">
            <span class="help-block" v-show="form.errors.has('email')">
                {{ form.errors.get('email') }}
            </span>
        </div>

        <div class="form-group row" >
            <div class="ml-auto col-sm-8">
                <div class="checkbox">
                    <label>
                        <input name="newsletter" v-model="form.newsletter" type="checkbox"> Keep me up to date on the
                        institute
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="ml-auto col-sm-8">
                <div class="checkbox">
                    <label>
                        <input name="is_company" v-model="form.is_company" type="checkbox"> Are you donating on behalf of a company?
                    </label>
                </div>
            </div>
        </div>

        <div v-show="form.is_company">
            <div class="form-group row" :class="{'has-error': form.errors.has('company')}">
                <label for="company" class="col-sm-4 control-label">Company Name*</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="company" id="company" v-model="form.company">
                    <span class="help-block" v-show="form.errors.has('company')">
                        {{ form.errors.get('company') }}
                    </span>
                </div>
            </div>

            <div class="form-group row" :class="{'has-error': form.errors.has('tax_id')}">
                <label for="tax_id" class="col-sm-4 control-label">Tax ID*</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="tax_id" id="tax_id" v-model="form.tax_id">
                    <span class="help-block" v-show="form.errors.has('tax_id')">
                        {{ form.errors.get('tax_id') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-8 ml-auto">
                <button type="submit" class="btn btn-primary" @click.prevent="donate" :disabled="form.busy">Donate Now</button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                form: new SparkForm({
                    stripeToken: '',
                    stripeEmail: '',
                    amount: 15,
                    subscription: 'monthly',
                    newsletter: true,
                    name: '',
                    email: '',
                    group: 'institute',
                    is_company: false,
                    company: '',
                    tax_id: ''
                })
            }
        },
        created() {
            this.form.name = this.user !== null ? this.user.name : '';
            this.form.email = this.user !== null ? this.user.email : '';

            this.configure();

            let self = this;
            this.eventHub.$on('updatedUser', function(user) {
                self.user = user;
                self.form.name = user.name;
                self.form.email = user.email;
                self.donate();
            })
        },
        methods: {
            donate() {

                if(this.form.subscription !== 'no' && this.user === null) {
                    this.eventHub.$emit('showLoginRegister');
                }
                else {
                    this.stripe.open({
                        name: 'Donation',
                        description: 'Some donation from an awesome human!',
                        zipCode: true,
                        email: this.form.email,
                        amount: this.form.amount * 100,
                        panelLabel: this.panelLabel,
                        allowRememberMe: false
                    });
                }
            },
            configure() {
                this.stripe = StripeCheckout.configure({
                    key: this.stripeKey,
                    image: "/img/sgdsocial.png",
                    locale: "auto",
                    zipCode: true,
                    billingAddress: true,
                    token: (token) => {
                        this.form.stripeToken = token.id;
                        this.form.stripeEmail = token.email;

                        Spark.post('/donations', this.form)
                            .then(response => {
                                location.href = response.redirect;
                            })
                            .catch(response => {
                                alert(response.message);
                            })
                    }
                });
            },
            updateUser(user) {
                $('#loginOrRegisterModal').modal('hide');

                if(this.form.name === '') {
                    this.form.name = user.name;
                }

                if(this.form.email === '') {
                    this.form.email = user.email;
                }
            }
        },
        computed: {
            panelLabel() {
                if(this.form.subscription == 'no') {
                    return 'Donate';
                }

                return 'Donate {{amount}} ' + this.form.subscription;
            },
            stripeKey() {
                if(this.form.group === 'mblgtacc') {
                    return SGDInstitute.mblgtaccStripe;
                }

                return SGDInstitute.instituteStripe;
            }
        }
    }

</script>