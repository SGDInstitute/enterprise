<template>
  <div>
    <button @click.prevent="show = true" :class="classes">
      <i class="fal fa-plus-circle fa-fw mr-4" aria-hidden="true"></i>
      {{ title }} Invoice
    </button>

    <portal to="modals" v-if="show">
      <modal :show="show" width="w-2/3">
        <div slot="header" class="p-6 bg-mint-200 flex justify-between">
          <h1 class="text-xl">{{ title }} Invoice</h1>
          <button
            @click="show = false"
            class="bg-mint-500 hover:bg-mint-700 rounded-full text-white h-6 w-6 shadow hover:shadow-lg"
          >
            <i class="fal fa-times fa-fw"></i>
          </button>
        </div>
        <div slot="body" class="p-6">
          <form @submit.prevent="create">
            <p
              class="leading-normal mb-4"
            >This information will be used to fill the "Bill To" section of the invoice. It will be emailed to you, as well as the email you specify below (if they are different). You will also be able to download a pdf invoice at any time.</p>
            <div class="flex mb-4 -mx-4">
              <div class="w-1/2 mx-4">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control" id="inputName" v-model="form.name" />
              </div>
              <div class="w-1/2 mx-4">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="text" class="form-control" id="inputEmail" v-model="form.email" />
              </div>
            </div>
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
            <div class="flex mb-4 -mx-4">
              <div class="w-1/3 mx-4">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" class="form-control" id="inputCity" v-model="form.city" />
              </div>
              <div class="w-1/3 mx-4">
                <label for="inputState" class="form-label">State</label>
                <div class="relative">
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
                  <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                  >
                    <svg
                      class="fill-current h-4 w-4"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                    >
                      <path
                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                      />
                    </svg>
                  </div>
                </div>
              </div>
              <div class="w-1/3 mx-4">
                <label for="inputZip" class="form-label">Zip</label>
                <input type="text" class="form-control" id="inputZip" v-model="form.zip" />
              </div>
            </div>
          </form>
        </div>
        <div slot="footer" class="p-6">
          <button type="button" class="btn btn-mint" @click.prevent="submit">Save</button>
        </div>
      </modal>
    </portal>
  </div>
</template>

<script>
export default {
  props: ["order", "user", "classes"],
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
      }),
      show: false
    };
  },
  created() {
    this.fillForm();
  },
  methods: {
    submit() {
      if (this.method === "create") {
        this.store();
      } else {
        this.update();
      }
    },
    store() {
      Spark.post("/orders/" + this.order.id + "/invoices", this.form)
        .then(response => {
          window.location.reload();
        })
        .catch(response => {
          alert(response.status);
        });
    },
    update() {
      Spark.patch("/invoices/" + this.order.invoice.id, this.form)
        .then(response => {
          window.location.reload();
        })
        .catch(response => {
          alert(response.status);
        });
    },
    fillForm() {
      if (this.method === "create") {
        this.form.name = this.order.user.name;
        this.form.email = this.order.user.email;
      } else {
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
      return this.method.charAt(0).toUpperCase() + this.method.slice(1);
    },
    method() {
      if (this.order.invoice === null) {
        return "create";
      }

      return "edit";
    }
  }
};
</script>