<template>
  <div>
    <div class="mb-4 flex -mx-4">
      <div class="w-1/2 mx-4">
        <label for="name" class="form-label">Name</label>
        <input type="text" id="name" v-model="name" class="form-control" />
      </div>

      <div class="w-1/2 mx-4">
        <label for="email" class="form-label">Email</label>
        <input type="text" id="email" v-model="email" class="form-control" />
      </div>
    </div>

    <div class="w-full mb-3">
      <label>
        <input name="is_company" v-model="is_company" type="checkbox" /> Are you donating on behalf of a
        company?
      </label>
    </div>

    <div v-show="is_company">
      <div class="w-full mb-3">
        <label for="company" class="form-label">Company Name *</label>
        <input type="text" class="form-control" name="company" id="company" v-model="company" />
      </div>

      <div class="w-full mb-3">
        <label for="tax_id" class="form-label">Tax ID *</label>
        <input type="text" class="form-control" name="tax_id" id="tax_id" v-model="tax_id" />
      </div>
    </div>

    <div class="w-full mb-3">
      <label class="form-label" for="amount">Amount *</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">$</span>
        </div>
        <input
          type="number"
          class="form-control"
          aria-label="Amount (to the nearest dollar)"
          placeholder="20"
          v-model="amount"
        />
        <div class="input-group-append">
          <span class="input-group-text">.00</span>
        </div>
      </div>
    </div>

    <div class="w-full mb-3">
      <label class="form-label" for="subscription">Would you like to repeat this gift? *</label>
      <div class="relative">
        <select name="subscription" id="subscription" class="form-control" v-model="subscription">
          <option value="no">No, this is one time only</option>
          <option value="monthly">Yes, repeat this gift monthly</option>
          <option value="quarterly">Yes, repeat this gift quarterly</option>
          <option value="yearly">Yes, repeat this gift yearly</option>
        </select>
        <div
          class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
        >
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
          </svg>
        </div>
      </div>
    </div>

    <div class="mt-8">
      <h2
        class="block uppercase tracking-wide text-gray-600 text-base font-semibold mb-4"
      >Payment Information</h2>

      <div class="mb-4">
        <label for="card" class="form-label">Credit Card</label>
        <div id="card" ref="card" class="form-control"></div>
        <div class="alert alert-error" v-if="card_error">{{ card_error }}</div>
      </div>
    </div>
    <div class="mb-4">
      <label for="address" class="form-label">Address</label>
      <input
        type="text"
        class="form-control"
        id="address"
        placeholder="185 Main St Unit 2"
        v-model="address_line1"
      />
    </div>
    <div class="md:flex mb-4 md:-mx-4">
      <div class="w-full md:w-3/5 md:mx-4">
        <label for="city" class="form-label">City</label>
        <input
          type="text"
          class="form-control"
          id="city"
          placeholder="Lansing"
          v-model="address_city"
        />
      </div>
      <div class="w-full md:w-1/5 md:mx-4">
        <label for="state" class="form-label">State</label>
        <input type="text" class="form-control" id="state" placeholder="MI" v-model="address_state" />
      </div>
      <div class="w-full md:w-1/5 md:mx-4">
        <label for="zip" class="form-label">Zip</label>
        <input type="text" class="form-control" id="zip" placeholder="48826" v-model="address_zip" />
      </div>
    </div>

    <div class="mt-6">
      <p class="italic text-sm" v-if="guest && subscription !== 'no'">
        Please
        <a href="/register" class="text-mint-700 hover:underline">create an account</a> or
        <a href="/login" class="text-mint-700 hover:underline">login</a>
        before making a {{ subscription }} donation.
      </p>

      <div class="alert alert-error" v-if="error">{{ error }}</div>

      <button
        @click="pay"
        :disabled="processing || (guest && subscription !== 'no')"
        class="mt-2 btn btn-mint btn-block"
      >Donate</button>
    </div>
  </div>
</template>

<script>
let style = {
  base: {
    fontSize: "16px"
  },
  invalid: {
    color: "#fa755a",
    iconColor: "#fa755a"
  }
};

export default {
  props: ["order", "classes", "group"],
  data() {
    return {
      address_line1: "",
      address_line2: "",
      address_city: "",
      address_state: "",
      address_zip: "",
      address_country: "US",
      amount: 25,
      card: "",
      card_error: "",
      company: "",
      email: "",
      error: "",
      is_company: false,
      name: "",
      processing: false,
      show: false,
      stripe: "",
      subscription: "monthly",
      tax_id: ""
    };
  },
  mounted() {
    if (window.SGDInstitute.user !== null) {
      this.name = window.SGDInstitute.user.name;
      this.email = window.SGDInstitute.user.email;
    }

    this.loadStripe();
  },
  methods: {
    loadStripe() {
      this.stripe = Stripe(window.SGDInstitute[this.group]);
      let elements = this.stripe.elements(),
        self = this;
      this.card = elements.create("card", { style: style });
      this.card.mount(this.$refs.card);

      this.card.addEventListener("change", function(event) {
        self.card_error = event.error ? event.error.message : "";
      });
    },
    makeOrder(token) {
      let self = this;
      self.processing = true;

      axios
        .post("/donations", {
          payment_token: token,
          name: this.name,
          email: this.email,
          amount: this.amount,
          company: this.company,
          subscription: this.subscription,
          tax_id: this.tax_id,
          group: this.group
        })
        .then(function(response) {
          let groupLabel = (self.group === 'institute') ? 'the Institute' : 'MBLGTACC';

          self.$toasted.show(`Successfully donated to ${groupLabel}`, {
            duration: 5000,
            type: "success"
          });

          window.location = response.data.redirect;
        })
        .catch(function(error) {
          self.processing = false;

          if (error.response.data.message === "") {
            self.error =
              "There was an unexpected issue, please contact support with the results from going to whatsmybrowser.org";
          } else {
            self.error = error.response.data.message;
          }
        });
    },
    pay() {
      let self = this;

      this.stripe.createToken(this.card, this.tokenData).then(function(result) {
        if (result.error) {
          this.error = result.error.message;
          self.$forceUpdate();
          return;
        }

        self.makeOrder(result.token.id);
      });
    }
  },
  computed: {
    guest() {
      return window.SGDInstitute.user === null;
    },
    tokenData() {
      return {
        name: this.name,
        address_line1: this.address_line1,
        address_line2: this.address_line2,
        address_city: this.address_city,
        address_state: this.address_state,
        address_zip: this.address_zip,
        address_country: this.address_country
      };
    }
  }
};
</script>