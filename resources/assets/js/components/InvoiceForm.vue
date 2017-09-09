<template>
    <div class="modal fade" id="invoiceForm" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }} Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="create">
                        <p>This information will be used to fill the "Bill To" section of the invoice. It will be emailed to you, as well as the email you specify below (if they are different). You will also be able to download a pdf invoice at any time.</p>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName" class="col-form-label">Name</label>
                                <input type="text" class="form-control" id="inputName" v-model="form.name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail" class="col-form-label">Email</label>
                                <input type="text" class="form-control" id="inputEmail" v-model="form.email">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputAddress" class="col-form-label">Address</label>
                                <input type="text" class="form-control" id="inputAddress" v-model="form.address"
                                       placeholder="1234 Main St">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputAddress2" class="col-form-label">Address 2</label>
                                <input type="text" class="form-control" id="inputAddress2" v-model="form.address_2"
                                       placeholder="Apartment, studio, or floor">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity" class="col-form-label">City</label>
                                <input type="text" class="form-control" id="inputCity" v-model="form.city">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputState" class="col-form-label">State</label>
                                <select id="inputState" class="form-control" v-model="form.state">
                                    <option value="AL">Alabama</option>
                                    <option value="AK">Alaska</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="CA">California</option>
                                    <option value="CO">Colorado</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="ID">Idaho</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="MT">Montana</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="OH">Ohio</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="OR">Oregon</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="TX">Texas</option>
                                    <option value="UT">Utah</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WA">Washington</option>
                                    <option value="WV">West Virginia</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="WY">Wyoming</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputZip" class="col-form-label">Zip</label>
                                <input type="text" class="form-control" id="inputZip" v-model="form.zip">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click.prevent="submit">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['order', 'user'],
        data() {
            return {
                form: new SparkForm({
                    name: '',
                    email: '',
                    address: '',
                    address_2: '',
                    city: '',
                    state: '',
                    zip: ''
                }),
                method: 'create',
            }
        },
        created() {
            this.fillForm();

            let self = this;
            this.eventHub.$on('showInvoiceForm', function (type) {
                self.method = type;
                $('#invoiceForm').modal('show');
            });
        },
        methods: {
            submit() {
                if(this.method === 'create') {
                    this.store();
                }
                else {
                    this.update();
                }
            },
            store() {
                Spark.post('/orders/' + this.order.id + '/invoices', this.form)
                    .then(response => {
                        $('#invoiceForm').modal('hide');
                        location.reload();
                    })
                    .catch(response => {
                        alert(response.status);
                    })
            },
            update() {
                Spark.patch('/invoices/' + this.order.invoice.id, this.form)
                    .then(response => {
                        $('#invoiceForm').modal('hide');
                    })
                    .catch(response => {
                        alert(response.status);
                    })
            },
            fillForm() {
                if(this.method === 'create') {
                    this.form.name = this.user.name;
                    this.form.email = this.user.email;
                }
                else {
                    this.form.name = this.order.invoice.name;
                    this.form.email = this.order.invoice.email;
                    this.form.address = this.order.invoice.address;
                    this.form.address_2 = this.order.invoice.address_2;
                    this.form.city = this.order.invoice.city;
                    this.form.state = this.order.invoice.state;
                    this.form.zip = this.order.invoice.zip;
                }
            }
        },
        computed: {
            title() {
                return this.method.charAt(0).toUpperCase() + this.method.slice(1)
            }
        }
    }
</script>