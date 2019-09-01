<template>
  <div>
    <button @click.prevent="show = true" :class="classes">
      <i class="fal fa-plus-circle fa-fw mr-4" aria-hidden="true"></i> Create Invoice
    </button>

    <portal to="modals" v-if="show">
      <modal :show="show" width="w-2/3">
        <div slot="header" class="p-6 bg-mint-200 flex justify-between">
          <h1 class="text-xl">Create Invoice</h1>
          <button
            @click="cancel"
            class="bg-mint-500 hover:bg-mint-700 rounded-full text-white h-6 w-6 shadow hover:shadow-lg"
          >
            <i class="fal fa-times fa-fw"></i>
          </button>
        </div>
        <div slot="body">
          <form @submit.prevent="create">
            <p>This information will be used to fill the "Bill To" section of the invoice. It will be emailed to you, as well as the email you specify below (if they are different). You will also be able to download a pdf invoice at any time.</p>
            <div class="form-row">
              <div class="mb-4">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control" id="inputName" v-model="form.name" />
              </div>
              <div class="mb-4">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="text" class="form-control" id="inputEmail" v-model="form.email" />
              </div>
            </div>
            <div class="form-row">
              <div class="mb-4">
                <label for="inputAddress" class="form-label">Address</label>
                <input
                  type="text"
                  class="form-control"
                  id="inputAddress"
                  v-model="form.address"
                  placeholder="1234 Main St"
                />
              </div>
              <div class="mb-4">
                <label for="inputAddress2" class="form-label">Address 2</label>
                <input
                  type="text"
                  class="form-control"
                  id="inputAddress2"
                  v-model="form.address_2"
                  placeholder="Apartment, studio, or floor"
                />
              </div>
            </div>
            <div class="form-row">
              <div class="mb-4">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" class="form-control" id="inputCity" v-model="form.city" />
              </div>
              <div class="form-group col-md-4">
                <label for="inputState" class="form-label">State</label>
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
                <label for="inputZip" class="form-label">Zip</label>
                <input type="text" class="form-control" id="inputZip" v-model="form.zip" />
              </div>
            </div>
          </form>
        </div>
        <div slot="footer" class="p-6"></div>
      </modal>
    </portal>
  </div>
</template>

<script>
export default {
  props: ["order", "classes"],
  data() {
    return {
      invoice: "",
      show: false
    };
  },
  created() {},
  methods: {
    data() {
      return {
        form: new SparkForm({
          name: "",
          email: "",
          address: "",
          address_2: "",
          city: "",
          state: "",
          zip: ""
        })
      };
    },
    cancel() {
      this.show = false;
    },
    resend() {
      axios
        .get("/invoices/" + self.order.invoice.id + "/resend")
        .then(function() {
          alert("Email sent!");
        });
    }
  }
};
</script>