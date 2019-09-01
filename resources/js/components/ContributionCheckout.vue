<template>
  <div>
    <button
      @click.prevent="checkout"
      :disabled="disable || processing"
      class="btn btn-mint btn-block"
    >Contribute</button>

    <portal to="modals" v-if="show">
      <modal :show="show">
        <div slot="header" class="p-6 bg-mint-200 flex justify-between">
          <h1 class="text-xl">Contribute ${{ total }} to {{ event.title }}</h1>
          <button
            @click="cancel"
            class="bg-mint-500 hover:bg-mint-700 rounded-full text-white h-6 w-6 shadow hover:shadow-lg"
          >
            <i class="fal fa-times fa-fw"></i>
          </button>
        </div>
        <div slot="body" class="p-6">
          <div class="mb-2">
            <label for="card" class="form-label">Credit Card</label>
            <div id="card" ref="card" class="form-control"></div>
            <div class="bg-yellow text-center text-black p-4 my-2" v-if="error">{{ error }}</div>
          </div>

          <div class="mb-2">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" v-model="name" class="form-control" />
          </div>

          <div>
            <label for="email" class="form-label">Email</label>
            <input type="text" id="email" v-model="email" class="form-control" />
          </div>

          <button @click="pay" :disabled="processing" class="mt-6 btn btn-mint btn-block">Contribute</button>
        </div>
      </modal>
    </portal>
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
  props: ["disable", "event", "contributions", "total"],
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
      price: "",
      stripe: "",
      card: "",
      name: "",
      email: ""
    };
  },
  mounted() {
    if (window.SGDInstitute.user) {
      this.name = window.SGDInstitute.user.name;
      this.email = window.SGDInstitute.user.email;
    }
  },
  methods: {
    cancel() {
      this.show = false;
      this.processing = false;
    },
    checkout() {
      this.show = true;
      Vue.nextTick(() => {
        this.loadStripe();
      });
    },
    loadStripe() {
      this.stripe = Stripe(window.SGDInstitute[this.event.stripe]);
      let elements = this.stripe.elements(),
        self = this;
      this.card = elements.create("card", { style: style });
      this.card.mount(this.$refs.card);

      let paymentRequest = this.stripe.paymentRequest({
        country: "US",
        currency: "usd",
        total: {
          label: "Contribute",
          amount: self.total
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
        .post("/api/donations/", {
          payment_token: token,
          contributions: this.contributions,
          event_id: this.event.id
        })
        .then(function(response) {
          self.$toasted.show(
            "Successfully contributed to " +
              self.event.name +
              ", you should be redirected shortly.",
            {
              duration: 5000,
              type: "success"
            }
          );
          window.location = response.data.url;
        })
        .catch(function(error) {
          self.error = error.response.data.message;
          self.processing = false;
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
  }
};
</script>
