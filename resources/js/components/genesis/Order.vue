<template>
  <div class="w-full md:w-1/2">
    <router-link
      to="/check-in"
      class="flex items-center block p-2 text-gray-200 no-underline hover:text-white mb-4"
    >
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
        <path
          class="fill-current inline"
          d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z"
        />
      </svg>
      <span class="text-lg pl-2">Back</span>
    </router-link>
    <div class="rounded shadow bg-white p-8 h-full overflow-hidden">
      <h1 class="text-3xl font-normal mb-8 text-blue-800">
        Order:
        <small>{{ number }}</small>
      </h1>

      <div class="mb-4">
        <div
          v-for="ticket in order.tickets"
          :key="ticket.hash"
          class="border rounded mb-1 flex justify-between"
        >
          <label class="text-lg p-4">
            <input type="checkbox" class="mr-2" v-model="tickets" :value="ticket" />
            <span v-if="ticket.user_id" class="pt-px">
              {{ ticket.user.name }}
              <small
                class="italic"
              >({{ ticket.user.profile.pronouns ? ticket.user.profile.pronouns : 'not listed' }})</small>
            </span>
            <span v-else class="pt-px italic">No user added to ticket</span>
          </label>
          <div class="p-4">
            <router-link
              :to="'/tickets/' + ticket.hash"
              class="no-underline p-2 rounded text-mint-500 hover:bg-gray-200 hover:text-mint-700"
            >Edit</router-link>
          </div>
        </div>
      </div>

      <div v-if="!isPaid && orderIsReady">
        <pay-with-card @paid="markAsPaid" :order="order"></pay-with-card>
        <pay-with-check @paid="markAsPaid" class="inline-block" :order="order"></pay-with-check>
      </div>
      <div v-else>
        <print-ticket class="inline-block" :disable="cannotPrint" :order="order" :tickets="tickets"></print-ticket>
      </div>

      <div v-if="error">
        <p class="text-lg">{{ error }}</p>
        <router-link
          to="/check-in"
          class="no-underline mt-4 inline-block text-center rounded bg-blue-500 px-3 py-2 text-white font-semibold hover:bg-blue-700"
        >Go Back</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import PayWithCard from "./Order/PayWithCard";
import PayWithCheck from "./Order/PayWithCheck";
import PrintTicket from "./Order/PrintTicket";

export default {
  name: "order",
  props: ["number"],
  data() {
    return {
      order: {},
      tickets: [],
      error: ""
    };
  },
  created() {
    this.$http
      .get("/api/orders/" + this.number)
      .then(response => {
        this.order = response.data;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.error = "An order with that confirmation number was not found.";
        } else {
          this.error = "Undefined issue, please ask for help.";
        }
      });
  },
  methods: {
    print() {
      let ids = _.map(this.tickets, function(ticket) {
        return ticket.id;
      }).join();
      this.$http.post("/api/queue/" + ids);
    },
    markAsPaid() {
      this.order.confirmation_number = "Confirmation Number";
    }
  },
  computed: {
    cannotPrint() {
      return (
        _.filter(this.tickets, function(ticket) {
          return ticket.user_id;
        }).length === 0
      );
    },
    isPaid() {
      return !_.isEmpty(this.order.confirmation_number);
    },
    orderIsReady() {
      return !_.isEmpty(this.order);
    }
  },
  components: { PayWithCard, PayWithCheck, PrintTicket }
};
</script>
