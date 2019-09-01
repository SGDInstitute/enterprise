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

    <div class="mb-4">
      <label for="card" class="form-label">Credit Card</label>
      <div id="card" ref="card" class="form-control"></div>
      <div class="bg-yellow text-center text-black p-4 my-2" v-if="error">{{ error }}</div>
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

    <div class="mt-6">
      <p class="italic text-sm" v-if="guest && subscription !== 'no'">
        Please
        <a href="/register" class="text-mint-700 hover:underline">create an account</a> or
        <a href="/login" class="text-mint-700 hover:underline">login</a>
        before making a {{ subscription }} donation.
      </p>
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
  props: ["order", "classes"],
  data() {
    return {
      show: false,
      error: "",
      processing: false,
      browserProcessing: false,
      canBrowserPay: false,
      isApplePay: false,
      rememberCard: false,
      browserType: "",
      stripe: "",
      card: "",
      name: "",
      email: "",
      amount: 25,
      company: "",
      tax_id: "",
      is_company: false,
      subscription: "monthly"
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
      this.stripe = Stripe(window.SGDInstitute["institute"]);
      let elements = this.stripe.elements(),
        self = this;
      this.card = elements.create("card", { style: style });
      this.card.mount(this.$refs.card);

      let paymentRequest = this.stripe.paymentRequest({
        country: "US",
        currency: "usd",
        total: {
          label: "Donate",
          amount: self.amount * 100
        },
        requestPayerName: true,
        requestPayerEmail: true
      });

      paymentRequest.canMakePayment().then(function(result) {
        if (result) {
          self.canBrowserPay = true;
          self.isApplePay = result.applePay;
        } else {
          self.canBrowserPay = false;
        }
      });

      paymentRequest.on("token", function(ev) {
        self.makeOrder(ev.token.id);
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
          company: this.company,
          tax_id: this.tax_id,
          group: "institute"
        })
        .then(function(response) {
          self.$toasted.show("Successfully donated to the Institute", {
            duration: 5000,
            type: "success"
          });

          window.location = response.data.redirect;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    pay() {
      let self = this;

      this.stripe.createToken(this.card).then(function(result) {
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
    }
  }
};
</script>